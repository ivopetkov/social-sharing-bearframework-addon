<?php

/*
 * Social sharing addon for Bear Framework
 * https://github.com/ivopetkov/social-sharing-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use IvoPetkov\BearFrameworkAddons\SocialSharingUtilities;

/**
 * @runTestsInSeparateProcesses
 */
class SocialSharingTest extends BearFramework\AddonTests\PHPUnitTestCase
{

    /**
     * 
     */
    public function testOutput()
    {
        $app = $this->getApp();

        $html = '<component src="social-sharing-button" url="https://google.com/"/>';
        $result = $app->components->process($html);

        $this->assertTrue(strpos($result, '-ivopetkov-social-sharing-get-window') !== false);
        $this->assertTrue(strpos($result, 'https://google.com/') !== false);
    }
}
