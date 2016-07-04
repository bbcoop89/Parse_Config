<?php


namespace ParseConfig\Factories;


use ParseConfig\Converters\AbstractConverter;
use ParseConfig\Converters\BooleanConverter;
use ParseConfig\Converters\DoubleConverter;
use ParseConfig\Converters\IntegerConverter;
use ParseConfig\Converters\StringConverter;
use ParseConfig\Helpers\ParseConfigValueHelper;
use ParseConfig\Validators\BooleanTypeValidator;
use ParseConfig\Validators\DoubleTypeValidator;
use ParseConfig\Validators\IntegerTypeValidator;


/**
 * Class ConfigurationValueConverterFactory
 * @package ParseConfig\Factories
 */
class ConfigurationValueConverterFactory
{
    /**
     * @param string $value
     * @return AbstractConverter
     */
    public static function getConfigurationValueConverter($value)
    {
        $converter = null;

        $trimmedValue = ParseConfigValueHelper::normalizeValue($value);

        switch(true) {
            case IntegerTypeValidator::isValid($trimmedValue):
                $converter = new IntegerConverter($trimmedValue);
                break;
            case DoubleTypeValidator::isValid($trimmedValue):
                $converter = new DoubleConverter($trimmedValue);
                break;
            case BooleanTypeValidator::isValid($trimmedValue):
                $converter = new BooleanConverter($trimmedValue);
                break;
            default:
                $converter = new StringConverter($trimmedValue);
                break;
        }

        return $converter;
    }
}