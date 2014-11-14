<?php

namespace Knife\Tests\System;


/**
 * Clean install Knife via composer and check if it runs.
 *
 * @author <dubgeiser+knife@gmail.com>
 */
class ComposerInstallTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string The directory at the time this test runs.
     */
    private $cwd;

    public function setUp()
    {
        $this->cwd = getcwd();
        chdir(__DIR__ . '/../assets/install');
        shell_exec('rm -fr vendor/ composer.lock');
        shell_exec('composer install');
    }

    public function tearDown()
    {
        shell_exec('rm -fr vendor/ composer.lock');
        chdir($this->cwd);
    }

    public function testShouldBeInstallableViaComposer()
    {
        $output = shell_exec('php test.php');
        $this->assertContains('123', $output);
    }
}

