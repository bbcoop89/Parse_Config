<?php

namespace ParseConfig\Settings;

use ParseConfig\Exceptions\ApplicationSettingNotFoundException;
use ParseConfig\Settings\ApplicationSettings as Config;

/**
 * Class DatabaseSettings
 * @package ParseConfig\Settings
 */
class DatabaseSettings
{
    /**
     * @var \PDO $mysqlPdo
     */
    private static $mysqlPdo;

    /**
     * @return \PDO
     * @throws ApplicationSettingNotFoundException
     */
    public static function getMySqlPdo()
    {
        if(self::$mysqlPdo instanceof \PDO) {
            return self::$mysqlPdo;
        } else {
            self::$mysqlPdo = new \PDO(
                'mysql:host=' . Config::getSetting('mysql.host') . ';dbname=' . Config::getSetting('mysql.dbname'),
                Config::getSetting('mysql.username'),
                Config::getSetting('mysql.password')
            );

            return self::$mysqlPdo;
        }
    }
}