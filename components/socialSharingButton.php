<?php
/*
 * Social sharing addon for Bear Framework
 * https://github.com/ivopetkov/social-sharing-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

$url = trim((string)$component->url);
$class = trim((string)$component->class);
$style = '';
if (strlen($class) === 0) {
    $class = 'ip-share-button';
    $style = '.ip-share-button{cursor:pointer;background-color:#3374ce;border:1px solid #3169c4;font-size:12px;font-family:Helvetica,Arial,sans-serif;font-weight:bold;display:inline-block;height:33px;line-height:32px;padding:0px 10px;color:#fff;border-radius:2px;}';
}

echo '<html><head>';
if ($style !== '') {
    echo '<style>' . $style . '</style>';
}
echo '<link rel="client-packages-embed" name="ivopetkov-social-sharing">';
echo '</head><body>';

echo '<span onclick="ivoPetkov.bearFrameworkAddons.socialSharingButton.open(\'' . htmlentities(implode("\'", explode("'", $url))) . '\');" class="' . htmlentities($class) . '">' . __('ivopetkov.socialSharing.Share') . '</span>';
echo '</body></html>';
