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

$elementID = 'ssb' . uniqid();
echo '<html><head>';
if ($style !== '') {
    echo '<style>' . $style . '</style>';
}
echo '<link rel="client-packages-embed" name="lightbox">';
echo '<link rel="client-packages-prepare" name="serverRequests">';
echo '</head><body>';

// Taken from socialSharingButton.js.min
$jsCode = '!function(){var n=document.getElementById("ELEMENTID_TO_REPLACE"),e="URL_TO_REPLACE";0===e.length&&(e=window.location.href.toString()),n.addEventListener("click",(function(){clientPackages.get("lightbox").then((function(n){var t=n.make(),o=function(){t.open(window.ssbwindowhtml.split("{encodedurl}").join(encodeURIComponent(e)))};void 0!==window.ssbwindowhtml?o():clientPackages.get("serverRequests").then((function(n){n.send("-ivopetkov-social-sharing-get-window").then((function(n){var e=JSON.parse(n);void 0!==e.html&&(window.ssbwindowhtml=e.html,o())}))}))}))}))}();';
echo '<span id="' . $elementID . '" class="' . htmlentities($class) . '">' . __('ivopetkov.socialSharing.Share') . '</span>';
echo '<script>' . str_replace(['ELEMENTID_TO_REPLACE', 'URL_TO_REPLACE'], [$elementID, htmlentities($url)], $jsCode) . '</script>';
echo '</body></html>';
