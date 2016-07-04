<?php


namespace ParseConfig\Helpers;


/**
 * Class ParseConfigValueHelper
 * @package ParseConfig\Helpers
 */
class ParseConfigValueHelper
{
    /**
     * @param string $value
     * @return string
     */
    public static function normalizeValue($value)
    {
        return trim($value);
    }
}