<?php

namespace AppBundle\Service\WubookAPI;

/**
 * Class TypeResolver
 * @package AppBundle\Service\WubookAPI
 */
class TypeResolver
{
    /**
     * Helps determine the type of value
     *
     * @param $value
     *
     * @return string
     * @throws \Exception
     */
    public static function resolve($value)
    {
        if(is_int($value)) return 'int';
        if(is_array($value)) return 'array';
        if(is_string($value)) return 'string';
        if(is_double($value)) return 'double';

        throw new \Exception(sprintf('Type "%s" does not exist'));
    }
}