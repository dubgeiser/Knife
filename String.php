<?php

namespace Knife;


/**
 * Collection of string related utilities.
 *
 * @author <dubgeiser+knife@gmail.com>
 */
class String
{
    /**
     * Check if a given piece of text begins with another given piece of text.
     *
     * @param string $subject Text to check.
     * @param string $what Text to look for.
     * @return bool Whether or not the string starts with the given text or not.
     */
    static function startsWith($subject, $what)
    {
        return mb_substr($subject, 0, mb_strlen($what)) == $what;
    }


    /**
     * Check if a given text ends with another given text.
     *
     * @param string $subject Text to check.
     * @param string $what Text to look for.
     * @return bool Whether or not the string ends with the given text.
     */
    static function endsWith($subject, $what)
    {
        return mb_substr($subject, -mb_strlen($what)) == $what;
    }
}
