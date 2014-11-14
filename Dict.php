<?php

namespace Knife;


/**
 * A dict is short for dictionary, which is another word for associative array.
 * Both "Dictionary" and "Associative array" are too long.  "Array" is asking for
 * name clashes (although namespaces should prevent this), so "Dict" it is.
 * It is a well-known term in the Python world.
 *
 * @author <dubgeiser+knife@gmail.com>
 */
class Dict
{
    /**
     * Return the value associated with the given key in the given array.
     * If the key does not exist, throw a KeyError, unless a default value
     * is supplied.  Do not throw a KeyError if the value for a key is null.
     *
     * IMO, this should be the default behaviour for getting values from (esp.) an
     * associative array.
     *
     * @return mixed The value represented by the given key.
     * @param array $data The data to get the value from.
     * @param string $key The key in that data whose value we need.
     * @param mixed $default Optional value to return if the key is not in the array.
     * @throws KeyError if the key was not found in the array and no default was given.
     */
    public static function get($data, $key)
    {
        // We need to assess the presence of $default by argument count since
        // everything could be a valid value for it: 0, false, null, ...
        $hasDefault = func_num_args() == 3;

        if (!$hasDefault && !isset($data[$key]) && !array_key_exists($key, $data)) {
            throw new KeyError($key);
        }

        return isset($data[$key]) || array_key_exists($key, $data)
            ? $data[$key] : func_get_arg(2);
    }
}
