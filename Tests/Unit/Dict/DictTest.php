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
    /** @type array Simple dictionary for veryfying behaviour. */
    private $dict = array('a' => 1);

    /** @type array Dictionary with an object as value. */
    private $dictWithObject;

    /** @type array Dictionary with null as value. */
    private $dictWithNull = array('a' => null);

    /** @type \stdClass Basic object to use as value in a dictionary */
    private $object;

    public function setUp()
    {
        $this->object = new \stdClass();
        $this->dictWithObject = array('a' => $this->object);
    }

    public function tearDown()
    {
        // nothing here... yet
    }


    public function testAccessExistingKey()
    {
        $this->assertSame(1, Dict::get($this->dict, 'a'));
    }

    /**
     * @expectedException Knife\KeyError
     */
    public function testAccessNonKeyThrowsKeyError()
    {
        Dict::get($this->dict, 'b');
    }

    public function testAccessNonKeyReturnsDefault()
    {
        $this->assertNull(Dict::get($this->dict, 'b', null));
    }

    public function testAccessKeyWithValueNullReturnsNull()
    {
        $this->assertNull(Dict::get($this->dictWithNull, 'a'));
    }

    public function testGetObjectReturnsReference()
    {
        $this->assertSame($this->object, Dict::get($this->dictWithObject, 'a'));
    }

    public function testGetObjectWithDefaultReturnsReference()
    {
        $this->assertSame($this->object, Dict::get($this->dictWithObject, 'b', $this->object));
    }
}
