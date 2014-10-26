<?php

namespace Knife\Tests\Shortcuts;

use Knife\Shortcuts;


class EnsureIdListTest extends \PHPUnit_Framework_TestCase
{
    public function testIntegersAsStringsAreCastToIntegers()
    {
        $this->assertSame(
            array(1, 2, 3),
            Shortcuts::ensureIdList(array('1', '2', '3'))
        );
    }

    public function testNonIntegerStringsAreCastToIntegers()
    {
        $this->assertSame(
            array(0, 0, 0),
            Shortcuts::ensureIdList(array('a', 'b', 'c'))
        );
    }

    public function testIntegersStayIntegers()
    {
        $this->assertSame(
            array(1, 2, 3),
            Shortcuts::ensureIdList(array(1, 2, 3))
        );
    }
}
