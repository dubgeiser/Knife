<?php

namespace Knife\Tests\Shortcuts;

use Knife\Shortcuts;


class MakeSqlIdPlaceHoldersTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldReturnCorrectAmountOfPlaceholders()
    {
        $ids = array(1, 2, 3, 4, 5);
        $this->assertSame(
            '?, ?, ?, ?, ?',
            Shortcuts::makeSqlIdPlaceHolders($ids)
        );
    }
}
