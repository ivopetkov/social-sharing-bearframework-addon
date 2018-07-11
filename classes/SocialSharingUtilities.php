<?php

/*
 * Social sharing addon for Bear Framework
 * https://github.com/ivopetkov/social-sharing-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov\BearFrameworkAddons;

use BearFramework\App;

class SocialSharingUtilities
{

    /**
     * 
     * @param string $url
     * @param bool $returnCachedValue
     * @return ?int
     */
    static function getSharesCount(string $url, bool $returnCachedValue = false): ?int
    {
        $app = App::get();
        $url = preg_replace("(^https?://)", "", $url);

        $cacheKey = 'social-sharing-count-' . md5($url);
        $value = $app->cache->getValue($cacheKey);
        if ($value !== null) {
            return (int) $value;
        }
        if ($returnCachedValue) {
            return null;
        }

        $cacheTTL = 60 * 60;

        $lockKey = 'ivopetkov-social-sharing-' . md5($url);
        $app->locks->acquire($lockKey);

        $count = null;
        $done = false;
        $dataKey = '.temp/ivopetkov-social-sharing/' . md5($url) . '.json';
        $data = $app->data->getValue($dataKey);
        $data = $data === null ? [] : json_decode($data, true);
        if (is_array($data) && isset($data['count'])) {
            $count = (int) $data['count'];
            if (isset($data['lastUpdateTime']) && $data['lastUpdateTime'] + $cacheTTL > time()) {
                $done = true;
            }
        }

        if (!$done) {

            $mh = curl_multi_init();
            $handles = [];
            $result = [];

            $add = function($url) use ($mh) {
                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $url);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
                curl_multi_add_handle($mh, $handle);
                return $handle;
            };

            $handles['facebook'] = $add('https://graph.facebook.com/?ids=' . rawurlencode('http://' . $url) . ',' . rawurlencode('https://' . $url));
            $handles['linkedin'] = $add('https://www.linkedin.com/countserv/count/share?url=' . rawurlencode('http://' . $url) . '&format=json');

            $active = null;
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

            while ($active && $mrc == CURLM_OK) {
                $selectResult = curl_multi_select($mh);
                if ($selectResult === -1) {
                    usleep(50);
                }
                do {
                    $mrc = curl_multi_exec($mh, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }

            foreach ($handles as $id => $handle) {
                $result[$id] = curl_multi_getcontent($handle);
                curl_multi_remove_handle($mh, $handle);
            }
            curl_multi_close($mh);

            $newCount = 0;

            $hasInvalidData = false;
            $getFacebookCount = function($result) use (&$hasInvalidData) {
                $count = null;
                if (strlen($result) > 0) {
                    $data = json_decode($result, true);
                    if (is_array($data)) {
                        foreach ($data as $item) {
                            if (is_array($item) && isset($item['share']) && is_array($item['share']) && isset($item['share']['share_count'])) {
                                if ($count === null) {
                                    $count = 0;
                                }
                                $count += (int) $item['share']['share_count'];
                            }
                        }
                    }
                }
                if ($count === null) {
                    $hasInvalidData = true;
                    return 0;
                }
                return $count;
            };
            $newCount += $getFacebookCount($result['facebook']);

            $getLinkedInCount = function($result) use (&$hasInvalidData) {
                if (strlen($result) > 0) {
                    $data = json_decode($result, true);
                    if (is_array($data) && isset($data['count'])) {
                        return (int) $data['count'];
                    }
                }
                $hasInvalidData = true;
            };
            $newCount += $getLinkedInCount($result['linkedin']);

            if (!$hasInvalidData) {
                $count = $newCount;
            }

            $app->data->setValue($dataKey, json_encode(['count' => $count, 'lastUpdateTime' => time()]));
        }

        $cacheItem = $app->cache->make($cacheKey, $count);
        $cacheItem->ttl = $cacheTTL;
        $app->cache->set($cacheItem);

        $app->locks->release($lockKey);

        return $count;
    }

}
