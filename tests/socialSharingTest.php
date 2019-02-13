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
        $this->assertEquals(SocialSharingUtilities::getSharesCount('https://google.com/', true), null);
        $this->assertTrue(SocialSharingUtilities::getSharesCount('https://google.com/') > 0);
        $app->cache->clear();
        $this->assertTrue(SocialSharingUtilities::getSharesCount('https://google.com/') > 0);
        $this->assertTrue(SocialSharingUtilities::getSharesCount('https://google.com/', true) > 0);
    }

}
