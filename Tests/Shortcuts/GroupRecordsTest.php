<?php

namespace Knife\Tests\Shortcuts;

use Knife\Shortcuts;


class GroupRecordsTest extends \PHPUnit_Framework_TestCase
{
    public function testGroupByExistingKey()
    {
        $this->assertSame(
            array(
                'm' => array(
                    array(
                        'name' => 'foo',
                        'age' => '4',
                        'gender' => 'm',
                    ),
                    array(
                        'name' => 'bar',
                        'age' => '6',
                        'gender' => 'm',
                    ),
                ),
                'f' => array(
                    array(
                        'name' => 'fu',
                        'age' => '6',
                        'gender' => 'f',
                    ),
                    array(
                        'name' => 'baz',
                        'age' => '3',
                        'gender' => 'f',
                    ),
                ),
            ),
            Shortcuts::groupRecords(
                array(
                    array(
                        'name' => 'foo',
                        'age' => '4',
                        'gender' => 'm',
                    ),
                    array(
                        'name' => 'bar',
                        'age' => '6',
                        'gender' => 'm',
                    ),
                    array(
                        'name' => 'fu',
                        'age' => '6',
                        'gender' => 'f',
                    ),
                    array(
                        'name' => 'baz',
                        'age' => '3',
                        'gender' => 'f',
                    ),
                ),
                'gender'
            )
        );
    }
}
