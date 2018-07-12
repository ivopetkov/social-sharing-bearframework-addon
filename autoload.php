<?php

/*
 * Social sharing addon for Bear Framework
 * https://github.com/ivopetkov/social-sharing-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

BearFramework\Addons::register('ivopetkov/social-sharing-bearframework-addon', __DIR__, [
    'require' => [
        'bearframework/localization-addon',
        'ivopetkov/html-server-components-bearframework-addon',
        'ivopetkov/server-requests-bearframework-addon',
        'ivopetkov/js-lightbox-bearframework-addon',
        'ivopetkov/locks-bearframework-addon'
    ]
]);
