<?php
namespace Knife\Tests\String;

use Knife\String;


/**
 * @author <dubgeiser+knife@gmail.com>
 */
class StringEndsWithTest extends \PHPUnit_Framework_TestCase
{
    function testIfEndsWithMatchesReturnTrue()
    {
        $this->assertTrue(String::endsWith("bobo", "o"));
    }

    function testIfEndsWithNotMatchesReturnFalse()
    {
        $this->assertFalse(String::endsWith("bobo", "a"));
    }

    function testIfEndsWithMatchesMultipleCharactersReturnTrue()
    {
        $this->assertTrue(String::endsWith("bobo", "obo"));
    }

    function testIfEndsWithNotMatchesMultipleCharactersReturnFalse()
    {
        $this->assertFalse(String::endsWith("bobo", "abo"));
    }

    function testSearchIsLongerThanSubjectReturnFalse()
    {
        $this->assertFalse(String::endsWith("bobo", "bobobobo"));
    }

    public function testEveryStringEndsWithAnEmptyString()
    {
        // Note: this mimics Python behaviour, on which endsWith() is based.
        $this->assertTrue(String::endsWith("something", ""));
        $this->assertTrue(String::endsWith("", ""));
    }
}
