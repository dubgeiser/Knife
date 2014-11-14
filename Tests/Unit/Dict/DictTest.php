<?php

namespace Knife\Tests;

use Knife\Dict;


/**
 * Test Dict class.
 *
 * @author <dubgeiser+knife@gmail.com>
 */
class DictTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessExistingKey()
    {
        $a = array('a' => 1);
        $this->assertSame(1, Dict::get($a, 'a'));
    }

    /**
     * @expectedException Knife\KeyError
     */
    public function testAccessNonKeyThrowsKeyError()
    {
        $a = array('a' => 1);
        Dict::get($a, 'b');
    }

    public function testAccessNonKeyReturnsDefault()
    {
        $a = array('a' => 1);
        $this->assertNull(Dict::get($a, 'b', null));
    }

    public function testAccessKeyWithValueNullReturnsNull()
    {
        $a = array('a' => null);
        $this->assertNull(Dict::get($a, 'a'));
    }

    public function testGetObjectReturnsReference()
    {
        $o = new \stdClass();
        $r = array('a' => $o,);
        $this->assertSame($o, Dict::get($r, 'a'));
    }

    public function testGetObjectWithDefaultReturnsReference()
    {
        $o = new \stdClass();
        $r = array('a' => $o,);
        $this->assertSame($o, Dict::get($r, 'b', $o));
    }
}
