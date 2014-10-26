<?php

namespace Knife;


/**
 * Error that will be thrown if a key does not exist in an array.
 *
 * @author <per@wijs.be>
 */
class KeyError extends \Exception
{
    /**
     * @param string $key The key that could not be found.
     */
    public function __construct($key)
    {
        parent::__construct("The key [$key] could not be found.");
    }
}
