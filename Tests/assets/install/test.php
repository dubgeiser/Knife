<?php
/*
 * Small test to see if Knife can be installed via composer.
 * To run this test:
 *
 *     $ cd Tests/ComposerInstall/
 *     $ php test.php
 */

require_once __DIR__ . '/vendor/autoload.php';

use Knife\Dict;


$a = array('a' => '123');
echo Dict::get($a, 'a'),
    "\n";
