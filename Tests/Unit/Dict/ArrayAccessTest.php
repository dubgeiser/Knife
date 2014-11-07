<?php

namespace Knife\Tests;

use Knife\Dict;


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
 * Ran into some problems with the use of array_key_exists() on objects
 * of classes implementing ArrayAccess, see
 * http://www.php.net/manual/en/class.arrayaccess.php#104061
 * We want Dict::get() to behave "correctly" (imho) in that circumstance.
 */
class ArrayAccessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \ArrayAccess
     */
    private $dict;

    public function setUp()
    {
        $this->dict = new ObjectImplementingArrayAccess();
    }

    public function tearDown()
    {
        unset($this->dict);
    }

    public function testExistingKey()
    {
        $this->assertSame(1, Dict::get($this->dict, 'a'));
    }

    /**
     * @expectedException Knife\KeyError
     */
    public function testNonKeyThrowsKeyError()
    {
        Dict::get($this->dict, 'b');
    }

    public function testNonKeyReturnsDefault()
    {
        $this->assertSame(5, Dict::get($this->dict, 'b', 5));
    }

    public function testGetObjectReturnsReference()
    {
        $o = new \stdClass();
        $this->dict['a'] = $o;
        $this->assertSame($o, Dict::get($this->dict, 'a'));
    }

    public function testGetObjectWithDefaultReturnsReference()
    {
        $o = new \stdClass();
        $this->assertSame($o, Dict::get($this->dict, 'b', $o));
    }
}
