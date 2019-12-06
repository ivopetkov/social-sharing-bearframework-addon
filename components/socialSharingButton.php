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
?><html><head><?php
        if ($style !== '') {
            echo '<style>' . $style . '</style>';
        }
        echo '<link rel="client-packages-embed" name="lightbox">';
        ?></head><body>
        <span id="<?= $elementID ?>" class="<?= $class ?>"><?= __('ivopetkov.socialSharing.Share') ?></span>
        <script>
            (function () {
                var element = document.getElementById('<?= $elementID ?>');
                var url = <?= json_encode((string) $url) ?>;
                if (url.length === 0) {
                    url = window.location.href.toString();
                }
                element.addEventListener('click', function () {
                    clientPackages.get('lightbox').then(function (lightbox) {
                        var context = lightbox.make();
                        var style = "cursor:pointer;display:inline-block;border-radius:4px;margin:10px;width:60px;height:60px;background-color:#fff;background-position:center center;background-repeat:no-repeat;background-size:80% 80%;";
                        var styles = {
                            'fb': "background-color:#365397;background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIj48cGF0aCBmaWxsPSIjZmZmIiBkPSJNMzI4LjEzIDkzLjc1Yy00My4xMyAwLTc4LjEzIDM1LTc4LjEzIDc4LjEzdjQ2Ljg3aC02Mi41djYyLjVIMjUwVjUwMGg2Mi41VjI4MS4yNWg3MC4zbDE1LjY0LTYyLjVIMzEyLjV2LTQ2Ljg4YzAtOC42IDcuMDMtMTUuNjIgMTUuNjMtMTUuNjJoNzguMTJ2LTYyLjVoLTc4LjEzeiIvPjwvc3ZnPg==')",
                            'tw': "background-color:#00a9f1;background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIj48cGF0aCBmaWxsPSIjZmZmIiBkPSJNMzMxLjAzIDEwNi43NWMtNDEgLjA2LTc0LjI4IDMzLjMzLTc0LjI4IDc0LjQ0IDAgNS44My42NiAxMS41MyAxLjkgMTctNjEuODgtMy4xNS0xMTYuOTQtMzIuOC0xNTMuNjItNzcuOS02LjQgMTEuMDItMTAuMSAyMy44NS0xMC4xIDM3LjQ3IDAgMjUuODMgMTMuMTUgNDguNjMgMzMuMTMgNjIuMDMtMTIuMi0uMzgtMjMuNy0zLjctMzMuNzUtOS4yN3YuODRjMCAzNi4xIDI1Ljc0IDY2LjI2IDU5LjggNzMuMTMtNi4yNCAxLjctMTIuODQgMi42My0xOS42NSAyLjYzLTQuNzcgMC05LjQ0LS42LTE0LjAzLTEuNDQgOS41NCAyOS42IDM3LjAyIDUxLjEgNjkuNjYgNTEuNzYtMjUuNTUgMTkuOTgtNTcuNiAzMS45LTkyLjUzIDMxLjktNi4wNyAwLTExLjktLjM4LTE3LjgtMS4xMkMxMTIuNTUgMzg5Ljc2IDE1MS43IDQwMiAxOTMuOSA0MDJjMTM3LjEgMCAyMTIuMTMtMTEzLjUyIDIxMi4xMy0yMTEuOTcgMC0zLjIzLS4xNy02LjQ4LS4yOC05LjY2IDE0LjYtMTAuNSAyNy4yOC0yMy43IDM3LjIyLTM4LjYydi0uMDZjLTEzLjM0IDUuOS0yNy43NCA5Ljk0LTQyLjg1IDExLjc2IDE1LjMzLTkuMjYgMjcuMjgtMjMuODUgMzIuOC00MS4yOC0xNC4zOCA4LjUtMzAuMzYgMTQuNzQtNDcuNCAxOC4xNC0xMy42LTE0LjUzLTMyLjktMjMuNi01NC41LTIzLjZ6Ii8+PC9zdmc+')",
                            'in': "background-color:#007bb6;background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIj48cGF0aCBmaWxsPSIjZmZmIiBkPSJNMTU2LjI1IDkzLjc1QzEzOS4wNSA5My43NSAxMjUgMTA3LjggMTI1IDEyNXMxNC4wNiAzMS4yNSAzMS4yNSAzMS4yNWMxNy4yIDAgMzEuMjUtMTQuMDYgMzEuMjUtMzEuMjUgMC0xNy4yLTE0LjA2LTMxLjI1LTMxLjI1LTMxLjI1ek0xMjUgMTg3LjV2MjE4Ljc1aDYyLjVWMTg3LjVIMTI1em05My43NSAwdjIxOC43NWg2Mi41di0xMjVjMC0xNy4yIDE0LjA2LTMxLjI1IDMxLjI1LTMxLjI1IDE3LjIgMCAzMS4yNSAxNC4wNiAzMS4yNSAzMS4yNXYxMjVoNjIuNVYyNjUuNjJjMC00My4xMi0zMS40OC03OC4xMi03MC4zLTc4LjEyLTIyLjEyIDAtNDEuOCAyMS4xLTU0LjcgMzguODRWMTg3LjVoLTYyLjV6Ii8+PC9zdmc+')",
                            'em': "background-color:#777777;background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIj48cGF0aCBmaWxsPSIjZmZmIiBkPSJNNzguNzUgMTIyLjQ0Yy01LjY0LS4xOC0xMS4yOCAyLjMzLTE0Ljg0IDcuMjItNS43IDcuOC0zLjkgMTguODIgMy45IDI0LjUzbDE3MS45IDEyNWMzLjA0IDIuMjQgNi43IDMuMzUgMTAuMyAzLjM1IDMuNiAwIDcuMi0xLjAzIDEwLjMtMy4zN2wxNzEuOS0xMjVjNy44LTUuOCA5LjctMTYuNzMgMy45LTI0LjU0LTUuOC03LjgyLTE2LjcyLTkuNi0yNC41My0zLjlMMjUwIDI0My4yNCA4OC40NCAxMjUuNzVjLTIuOTMtMi4xNC02LjMtMy4yLTkuNy0zLjN6bTI1MCAxNTAuNDRjLTUuNjQtLjItMTEuMjggMi4zLTE0Ljg0IDcuMjUtNS43IDcuOS0zLjkgMTguODQgMy45IDI0LjYybDkzLjc3IDY4LjJjMy4xMyAyLjI1IDYuNzIgMy4zNiAxMC4zIDMuMzYgNS40IDAgMTAuOC0yLjU3IDE0LjIzLTcuMjZ2LS4wNmM1LjctNy44IDMuOS0xOC44My0zLjktMjQuNTNsLTkzLjc2LTY4LjIyYy0yLjkzLTIuMTQtNi4zLTMuMjMtOS43LTMuMzV6bS0xNTcuNTMuMWMtMy4zNy4xLTYuNzMgMS4yLTkuNjYgMy4zM0w2Ny44IDM0NC41Yy03LjggNS43OC05LjYgMTYuNzItMy45IDI0LjUzIDMuNDQgNC43NyA4Ljc2IDcuMjggMTQuMjMgNy4yOCAzLjYgMCA3LjE4LTEgMTAuMy0zLjM1bDkzLjc2LTY4LjEzdi0uMDVjNy44LTUuNzggOS42Ny0xNi43MiAzLjktMjQuNTMtMy42My00Ljg4LTkuMjctNy40My0xNC45LTcuMjV6Ii8+PC9zdmc+')"
                        };
                        var html = '<div>' +
                                '<div style="font-family:Helvetica,Arial,sans-serif;font-size:1.5rem;color:#fff;text-align:center;cursor:default;padding-bottom:0.5rem;"><?= htmlspecialchars(__('ivopetkov.socialSharing.ShareOn')) ?><\/div>' +
                                '<div>' +
                                '<a title="<?= htmlentities(__('ivopetkov.socialSharing.ShareOnFacebook')) ?>" rel="noopener" href="http://www.facebook.com/share.php?u=' + encodeURIComponent(url) + '" target="_blank" style="' + style + styles['fb'] + '"><\/a>' +
                                '<a title="<?= htmlentities(__('ivopetkov.socialSharing.ShareOnTwitter')) ?>" rel="noopener" href="http://twitter.com/intent/tweet?status=' + encodeURIComponent(url) + '" target="_blank" style="' + style + styles['tw'] + '"><\/a>' +
                                '<a title="<?= htmlentities(__('ivopetkov.socialSharing.ShareOnLinkedIn')) ?>" rel="noopener" href="http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(url) + '" target="_blank" style="' + style + styles['in'] + '"><\/a>' +
                                '<a title="<?= htmlentities(__('ivopetkov.socialSharing.ShareInAnEmail')) ?>" rel="noopener" href="mailto:?subject=&body=' + encodeURIComponent(url) + '" style="' + style + styles['em'] + '"><\/a>' +
                                '<\/div>' +
                                '<\/div>';
                        context.open(html);
                    });
                });
            })();
        </script>
    </body>
</html>