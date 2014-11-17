<?php
namespace Knife\Tests\String;

use Knife\String;


/**
 * @author <dubgeiser+knife@gmail.com>
 */
class StringStartsWithTest extends \PHPUnit_Framework_TestCase
{
    function testIfStartsWithMatchesReturnTrue()
    {
        $this->assertTrue(String::startsWith("bobo", "b"));
    }

    function testIfStartsWithNotMatchesReturnFalse()
    {
        $this->assertFalse(String::startsWith("bobo", "a"));
    }

    function testIfStartsWithMatchesMultipleCharactersReturnTrue()
    {
        $this->assertTrue(String::startsWith("bobo", "bob"));
    }

    function testIfStartsWithNotMatchesMultipleCharactersReturnFalse()
    {
        $this->assertFalse(String::startsWith("bobo", "bab"));
    }

    function testSearchIsLongerThanSubjectReturnFalse()
    {
        $this->assertFalse(String::startsWith("bobo", "bobobobo"));
    }

    function testSpecialCharactersShouldWork()
    {
        $subject = "öÚŸöØ{êÊÊ{ç!à}ÏÏ}";
        $this->assertTrue(String::startsWith($subject, "öÚŸ"));
        $this->assertFalse(String::startsWith($subject, "¨o¨o"));
    }

    public function testEveryStringStartsWithAnEmptyString()
    {
        // Note: this mimics Python behaviour, on which startsWith() is based.
        $this->assertTrue(String::startsWith("whatever", ""));
        $this->assertTrue(String::startsWith("", ""));
    }
}
