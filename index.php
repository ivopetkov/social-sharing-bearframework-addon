<?php

/*
 * Social sharing addon for Bear Framework
 * https://github.com/ivopetkov/social-sharing-bearframework-addon
 * Copyright (c) 2018 Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App;
use IvoPetkov\BearFrameworkAddons\SocialSharingUtilities;

$app = App::get();
$context = $app->context->get(__FILE__);

$context->classes
        ->add('IvoPetkov\BearFrameworkAddons\SocialSharingUtilities', 'classes/SocialSharingUtilities.php');

$app->components
        ->addAlias('social-sharing-button', 'file:' . $context->dir . '/components/socialSharingButton.php');

$app->localization
        ->addDictionary('en', function() use ($context) {
            return include $context->dir . '/locales/en.php';
        })
        ->addDictionary('bg', function() use ($context) {
            return include $context->dir . '/locales/bg.php';
        })
        ->addDictionary('ru', function() use ($context) {
            return include $context->dir . '/locales/ru.php';
        });

$app->serverRequests
        ->add('ivopetkov-social-sharing-get-count', function($data) {
            if (isset($data['url']) && is_string($data['url'])) {
                $count = SocialSharingUtilities::getSharesCount($data['url']);
            } else {
                $count = 0;
            }
            return json_encode(['count' => $count], true);
        });
