<?php


namespace ParseConfig\Settings;

use ParseConfig\Exceptions\ApplicationSettingNotFoundException;


/**
 * Class AppConfig
 * @package ParseConfig\Settings
 */
class ApplicationSettings
{
    /**
     * @var array $applicationSettings
     */
    private static $applicationSettings;

    /**
     * @param array $configurations
       */
    public static function init(array $configurations)
    {
        foreach($configurations as $key => $value) {
            self::$applicationSettings[$key] = $value;
        }
    }

    /**
     * @param string $key
     * @return mixed
     * @throws ApplicationSettingNotFoundException
     */
    public static function getSetting($key)
   {
       if(!array_key_exists($key, self::$applicationSettings)) {
           throw new ApplicationSettingNotFoundException(
               sprintf("Application setting ['%s'] not found.", $key)
           );
       }

       return self::$applicationSettings[$key];
   }

    /**
     * @return array
     */
    public static function getApplicationSettings()
    {
        return self::$applicationSettings;
    }

    /**
     * @param array $applicationSettings
     */
    public static function setApplicationSettings(array $applicationSettings)
    {
        self::$applicationSettings = $applicationSettings;
    }
}