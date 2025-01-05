<?php

/*
 * Social sharing addon for Bear Framework
 * https://github.com/ivopetkov/social-sharing-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App;

$app = App::get();
$context = $app->contexts->get(__DIR__);

$context->assets
    ->addDir('assets');

$app->components
    ->addAlias('social-sharing-button', 'file:' . $context->dir . '/components/socialSharingButton.php');

$app->localization
    ->addDictionary('en', function () use ($context) {
        return include $context->dir . '/locales/en.php';
    })
    ->addDictionary('bg', function () use ($context) {
        return include $context->dir . '/locales/bg.php';
    })
    ->addDictionary('ru', function () use ($context) {
        return include $context->dir . '/locales/ru.php';
    });

$app->serverRequests
    ->add('-ivopetkov-social-sharing-get-window', function ($data) {
        $styles = [
            'fb' => "background-size:30px;background-color:#3c63a5;background-image:url('data:image/svg+xml;base64," . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" fill="#fff"><path d="M132.49 108.199l3.895-25.282h-24.257V66.519c0-6.901 3.382-13.666 14.247-13.666h11.035V31.329s-10.01-1.708-19.576-1.708c-19.986 0-33.037 12.094-33.037 34.028v19.269H62.59V108.2h22.207v62.18h27.332V108.2z"/></svg>') . "')",
            'tw' => "background-size:30px;background-color:#00b3e1;background-image:url('data:image/svg+xml;base64," . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" fill="#fff"><path d="M110.931444 91.008481l42.775897-49.72352h-10.136518l-37.142306 43.174234-29.665451-43.174234H42.54748l44.859983 65.287088-44.859983 52.142745h10.137093l39.223232-45.593459 31.328889 45.593459h34.215585l-46.523326-67.706313zm-13.884138 16.138762l-4.545251-6.501122-36.164945-51.730103h15.569983l29.185532 41.747844 4.545251 6.501122 37.937735 54.265803h-15.569983l-30.958321-44.281054z"/></svg>') . "')",
            'in' => "background-size:30px;background-color:#0077b5;background-image:url('data:image/svg+xml;base64," . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" fill="#fff"><g transform="matrix(.43604 0 0 .43604 -11.44 -8.541)"><circle cx="142" cy="138" r="37"/><path d="M244 194v198M142 194v198"/><path d="M109 194v198h66V194zm102 0v198h66V194z"/><path d="M276 282c0-20 13-40 36-40 24 0 33 18 33 45v105h66V279c0-61-32-89-76-89-34 0-51 19-59 32"/></g></svg>') . "')",
            'em' => "background-position:left 10px center;background-size:28px;background-color:#3d3d3d;background-image:url('data:image/svg+xml;base64," . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" fill="none" stroke="#fff" stroke-width="9.562" stroke-linejoin="round"><path d="M36.251 55.376h127.498v89.249H36.251z"/><path d="M36.251 55.376L100 112.75l63.749-57.374M36.251 144.624L79.76 94.9m83.989 49.724l-43.63-49.864" stroke-linecap="round"/></svg>') . "')",
            'cp' => "background-position:left 13px center;background-size:22px;background-color:#3d3d3d;background-image:url('data:image/svg+xml;base64," . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" fill="none" stroke="#fff" stroke-width="45.6344" stroke-linejoin="round"><path d="M164.730924 141.913724h273.8064v319.4408h-273.8064z"/><path d="M347.268524 50.644924h-273.8064v319.4408" stroke-linecap="round"/></svg>') . "')",
            'sh' => "background-position:left 13px center;background-size:22px;background-color:#3d3d3d;background-image:url('data:image/svg+xml;base64," . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="377.952766" height="377.952766" viewBox="0 0 100 100"><g transform="matrix(4.5854 0 0 4.5854 -5.0242408 -5.0242408)" fill="none" stroke="#fff" stroke-linejoin="round" stroke-width="2"><path d="M16 8l-8 3zm0 8l-8-3z"/><circle cx="6" cy="12" r="2"/><circle cx="18" cy="7" r="2"/><circle cx="18" cy="17" r="2"/></g></svg>') . "')"
        ];
        $html = '<html>' .
            '<head>' .
            '<style>.ip-social-buttons a{font-family:Helvetica,Arial,sans-serif;font-size:16px;color:#fff;margin:10px auto;cursor:pointer;border-radius:4px;width:250px;height:44px;line-height:46px;text-decoration:none;padding-left:48px;padding-right:15px;background-position:left 9px center;background-repeat:no-repeat;display:block;box-sizing:border-box;}' .
            '</style>' .
            '</head>' .
            '<body>' .
            '<div>' .
            '<div class="ip-social-buttons">' .
            '<a title="' . htmlentities(__('ivopetkov.socialSharing.ShareOnFacebook')) . '" rel="noopener" href="http://www.facebook.com/share.php?u={encodedurl}" target="_blank" style="' . $styles['fb'] . '">' . htmlspecialchars(__('ivopetkov.socialSharing.ShareOnFacebook')) . '</a>' .
            '<a title="' . htmlentities(__('ivopetkov.socialSharing.ShareOnTwitter')) . '" rel="noopener" href="http://twitter.com/intent/tweet?status={encodedurl}" target="_blank" style="' . $styles['tw'] . '">' . htmlspecialchars(__('ivopetkov.socialSharing.ShareOnTwitter')) . '</a>' .
            '<a title="' . htmlentities(__('ivopetkov.socialSharing.ShareOnLinkedIn')) . '" rel="noopener" href="http://www.linkedin.com/shareArticle?mini=true&url={encodedurl}" target="_blank" style="' . $styles['in'] . '">' . htmlspecialchars(__('ivopetkov.socialSharing.ShareOnLinkedIn')) . '</a>' .
            '<a title="' . htmlentities(__('ivopetkov.socialSharing.ShareInAnEmail')) . '" rel="noopener" href="mailto:?subject=&body={encodedurl}" style="' . $styles['em'] . '">' . htmlspecialchars(__('ivopetkov.socialSharing.ShareInAnEmail')) . '</a>' .
            '<a title="' . htmlentities(__('ivopetkov.socialSharing.CopyURL')) . '" data-ipsssbt="' . htmlentities(__('ivopetkov.socialSharing.CopyURLDone')) . '" data-ipssb="c" style="' . $styles['cp'] . '">' . htmlspecialchars(__('ivopetkov.socialSharing.CopyURL')) . '</a>' .
            '<a title="' . htmlentities(__('ivopetkov.socialSharing.DeviceShare')) . '" data-ipssb="o" style="' . $styles['sh'] . '">' . htmlspecialchars(__('ivopetkov.socialSharing.DeviceShare')) . '</a>' .
            '</div>' .
            '</div>' .
            '</body>' .
            '</html>';
        return json_encode(['html' => $html]);
    });

$app->clientPackages
    ->add('ivopetkov-social-sharing', function (IvoPetkov\BearFrameworkAddons\ClientPackage $package) use ($context): void {
        //$package->addJSCode(file_get_contents(__DIR__ . '/dev/social-sharing-button.js')); // dev mode
        $package->addJSFile($context->assets->getURL('assets/social-sharing-button.min.js', ['cacheMaxAge' => 999999999, 'version' => 2, 'robotsNoIndex' => true]));
        $package->embedPackage('lightbox');
        $package->embedPackage('serverRequests');
    });
