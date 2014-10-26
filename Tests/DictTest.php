<?php

namespace Knife\Tests;

use Knife\Dict;
use Knife\KeyError;


/**
 * Only has 1 element (default value = 1), which can be accessed by the key 'a'.
 */
class ObjectImplementingArrayAccess implements \ArrayAccess
{
    private $value = 1;

    public function offsetExists($key)
    {
        return $key == 'a';
    }

    public function offsetGet($key)
    {
        return $key == 'a' ? $this->value : null;
    }

    public function offsetSet($key, $value)
    {
        $this->value = $value;
    }

    public function offsetUnset($key)
    {
        unset($this->value);
    }
}


/**
 * Test Dict class.
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


    /*
     * Ran into some problems with the use of array_key_exists() on objects
     * of classes implementing ArrayAccess, see
     * http://www.php.net/manual/en/class.arrayaccess.php#104061
     * We want Dict::get() to behave "correctly" (imho) in that circumstance.
     */
    public function testArrayAccessExistingKey()
    {
        $a = new ObjectImplementingArrayAccess();
        $this->assertSame(1, Dict::get($a, 'a'));
    }

    /**
     * @expectedException Knife\KeyError
     */
    public function testArrayAccessNonKeyThrowsKeyError()
    {
        $a = new ObjectImplementingArrayAccess();
        Dict::get($a, 'b');
    }

    public function testArrayAccessNonKeyReturnsDefault()
    {
        $a = new ObjectImplementingArrayAccess();
        $this->assertSame(5, Dict::get($a, 'b', 5));
    }

    public function testArrayAccessGetObjectReturnsReference()
    {
        $o = new \stdClass();
        $r = new ObjectImplementingArrayAccess();
        $r['a'] = $o;
        $this->assertSame($o, Dict::get($r, 'a'));
    }

    public function testArrayAccessGetObjectWithDefaultReturnsReference()
    {
        $o = new \stdClass();
        $r = new ObjectImplementingArrayAccess();
        $r['a'] = $o;
        $this->assertSame($o, Dict::get($r, 'b', $o));
    }
}
