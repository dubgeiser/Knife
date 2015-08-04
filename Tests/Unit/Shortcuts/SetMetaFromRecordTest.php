<?php
namespace Knife\Tests\Shortcuts;

use Knife\Shortcuts;

/**
 * @author <dubgeiser+knife@gmail.com>
 */
class SetMetaFromRecordTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->header = $this->getMock(
            'Frontend\Core\Engine\Header',
            array(
                '__construct', // bypass KernelInterface args on ctor
                'setPageTitle',
                'addMetaDescription',
                'addMetaKeywords',
                'addMetaData',
            ),
            array(), // not passing any args to ctor
            'Header',
            false // do not call the original constructor
        );
    }

    public function testSetPageTitleWithOverwrite()
    {
        $record = array(
            'meta_title' => 'test',
            'meta_title_overwrite' => 'Y'
        );
        $this->header->expects($this->once())
            ->method('setPageTitle')
            ->with('test', true);
        Shortcuts::setMetaFromRecord($this->header, $record);
    }

    public function testSetPageTitleWithoutOverwrite()
    {
        $record = array(
            'meta_title' => 'test',
            'meta_title_overwrite' => 'N'
        );
        $this->header->expects($this->once())
            ->method('setPageTitle')
            ->with('test', false);
        Shortcuts::setMetaFromRecord($this->header, $record);
    }
}
