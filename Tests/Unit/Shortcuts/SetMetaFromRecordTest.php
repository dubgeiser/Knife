<?php
namespace Knife\Tests\Shortcuts;

use Knife\Shortcuts;

/**
 * @author <dubgeiser+knife@gmail.com>
 */
class SetMetaFromRecordTest extends \PHPUnit_Framework_TestCase
{
    const DO_NOT_CALL_ORIGINAL_CTOR = false;

    static $metaPartToHeaderMethodMap = array(
        'title' => 'setPageTitle',
        'description' => 'addMetaDescription',
        'keywords' => 'addMetaKeywords',
    );

    public function setUp()
    {
        $this->setUpHeaderMock();
    }

    /**
     * @internal Setting up header mock separately; we need to be able to restore
     *           it in its original state.  (see expectMetaSetCorrectly())
     *           2015-08-04 I have not found a way (yet) to do this in PHPUnit.
     */
    private function setUpHeaderMock()
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
            self::DO_NOT_CALL_ORIGINAL_CTOR
        );
    }

    public function testSettingMetaValues()
    {
        foreach (self::$metaPartToHeaderMethodMap as $metaPart => $method) {
            $this->expectMetaSetCorrectly($metaPart, $method);
        }
    }

    public function testSettingSeoValues()
    {
        $record = array(
            'meta_data' => array(
                'seo_index' => 'noindex',
                'seo_follow' => 'nofollow',
            )
        );
        $this->header->expects($this->exactly(2))
            ->method('addMetaData')
            ->withConsecutive(
                array(
                    array(
                        'name' => 'robots',
                        'content' => $record['meta_data']['seo_index']
                    )
                ),
                array(
                    array(
                        'name' => 'robots',
                        'content' => $record['meta_data']['seo_follow']
                    )
                )
            );
        Shortcuts::setMetaFromRecord($this->header, $record);
    }

    /**
     * @param string $metaPart Part of the meta key to be set.
     * @param string $method Method that should be expected to be called on the
     *        Header object (see $this->header setup).
     */
    private function expectMetaSetCorrectly($metaPart, $method)
    {
        $expectedValue = 'test';
        $keyMeta = "meta_$metaPart";
        $keyMetaOverwrite = "{$keyMeta}_overwrite";
        $record = array(
            $keyMeta => $expectedValue,
        );
        foreach (array('Y', 'N') as $overwriteValue) {
            $record[$keyMetaOverwrite] = $overwriteValue;
            $expectedOverwriteValue = $overwriteValue == 'Y';
            $this->setUpHeaderMock();
            $this->header->expects($this->once())
                ->method($method)
                ->with($expectedValue, $expectedOverwriteValue);
            Shortcuts::setMetaFromRecord($this->header, $record);
        }
    }
}
