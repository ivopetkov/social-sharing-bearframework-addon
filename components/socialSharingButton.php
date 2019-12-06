<?php
/*
 * Social sharing addon for Bear Framework
 * https://github.com/ivopetkov/social-sharing-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App;

$app = App::get();
$context = $app->contexts->get(__FILE__);

$url = trim($component->url);
$class = trim($component->class);
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
?><span id="<?= $elementID ?>" class="<?= $class ?>"><?= __('ivopetkov.socialSharing.Share') ?></span>
<script>
    (function() {
        var element = document.getElementById('<?= $elementID ?>');
        var url = <?= json_encode((string) $url) ?>;
        if (url.length === 0) {
            url = window.location.href.toString();
        }
        element.addEventListener('click', function() {
            clientPackages.get('lightbox').then(function(lightbox) {
                var context = lightbox.make();
                var open = function() {
                    context.open(window.ssbwindowhtml.split('{encodedurl}').join(encodeURIComponent(url)));
                };
                if (typeof window.ssbwindowhtml !== 'undefined') {
                    open();
                } else {
                    clientPackages.get('serverRequests').then(function(serverRequests) {
                        serverRequests.send('-ivopetkov-social-sharing-get-window').then(function(responseText) {
                            var result = JSON.parse(responseText);
                            if (typeof result.html !== 'undefined') {
                                window.ssbwindowhtml = result.html;
                                open();
                            }
                        });
                    });
                }
            });
        });
    })();
</script><?php
            echo '</body></html>';
