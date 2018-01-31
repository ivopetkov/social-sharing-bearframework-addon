<?php

/*
 * Social sharing addon for Bear Framework
 * https://github.com/ivopetkov/social-sharing-bearframework-addon
 * Copyright (c) 2018 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov\BearFrameworkAddons;

use BearFramework\App;

class SocialSharingUtilities
{

    static function getSharesCount(string $url, bool $returnCachedValue = false): ?int
    {
        $app = App::get();
        $url = preg_replace("(^https?://)", "", $url);

        $cacheKey = 'social-sharing-count-' . $url;
        $value = $app->cache->getValue($cacheKey);
        if ($value !== null) {
            return (int) $value;
        } else {
            if ($returnCachedValue) {
                return null;
            }
        }

        $mh = curl_multi_init();
        $handles = [];
        $result = [];

        $addFacebook = function($url) use ($mh) {
            $url = 'https://graph.facebook.com/?id=' . rawurlencode($url);
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_multi_add_handle($mh, $handle);
            return $handle;
        };
        $handles['facebook1'] = $addFacebook('http://' . $url);
        $handles['facebook2'] = $addFacebook('https://' . $url);

        $addLinkedIn = function($url) use ($mh) {
            $url = 'https://www.linkedin.com/countserv/count/share?url=' . rawurlencode($url) . '&format=json';
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_multi_add_handle($mh, $handle);
            return $handle;
        };
        $handles['linkedin'] = $addLinkedIn('http://' . $url);

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

        $count = 0;

        $getFacebookCount = function($result) {
            if (strlen($result) > 0) {
                $data = json_decode($result, true);
                if (is_array($data) && isset($data['share']) && is_array($data['share']) && isset($data['share']['share_count'])) {
                    return (int) $data['share']['share_count'];
                }
            }
        };
        $count += $getFacebookCount($result['facebook1']);
        $count += $getFacebookCount($result['facebook2']);

        $getFacebookCount = function($result) {
            if (strlen($result) > 0) {
                $data = json_decode($result, true);
                if (is_array($data) && isset($data['count'])) {
                    return (int) $data['count'];
                }
            }
        };
        $count += $getFacebookCount($result['linkedin']);

        $cacheItem = $app->cache->make($cacheKey, $count);
        $cacheItem->ttl = 60 * 60;
        $app->cache->set($cacheItem);
        return $count;
    }

}
