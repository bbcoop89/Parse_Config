<?php


namespace ParseConfig\Services;



/**
 * Class QueryService
 * @package ParseConfig\Services
 */
class QueryService
{
    /**
     * @var string
     */
    private static $insertConfigSql = <<<SQL
    INSERT INTO config (
      config_key,
      config_value,
      config_file_id,
      config_type_id
    ) VALUES (
      :configKey,
      :configValue,
      :fileId,
      :typeId
    )
SQL;

    /**
     * @var string
     */
    private static $insertConfigurationFileSql = <<<SQL
    INSERT INTO config_file (
      config_file_name
    ) VALUES (
      :fileName
    )
SQL;

    /**
     * @var string
     */
    private static $selectConfigurationTypeSql = <<<SQL
    SELECT config_type_id
    FROM config_type
    WHERE
    config_type_name = :typeName
SQL;

    /**
     * @var string
     */
    private static $getByKeySql = <<<SQL
    SELECT
    *
    FROM config
    INNER JOIN config_file AS file
    ON file.config_file_id = config.config_file_id
    INNER JOIN config_type AS cType
    ON cType.config_type_id = config.config_type_id
    WHERE
    config.config_key = :key
SQL;

    /**
     * @var string
     */
    private static $getTypeByIdSql = <<<SQL
    SELECT
    *
    FROM
    config_type
    WHERE
    config_type_id = :typeId
SQL;

    /**
     * @var string
     */
    private static $getFileByIdSql = <<<SQL
    SELECT
    *
    FROM
    config_file
    WHERE
    config_file_id = :fileId
SQL;

    /**
     * @return string
     */
    public static function insertConfiguration()
    {
        return self::$insertConfigSql;
    }

    /**
     * @return string
     */
    public static function insertConfigurationFile()
    {
        return self::$insertConfigurationFileSql;
    }

    /**
     * @return string
     */
    public static function selectConfigurationType()
    {
        return self::$selectConfigurationTypeSql;
    }

    /**
     * @return string
     */
    public static function selectConfigurationByKey()
    {
        return self::$getByKeySql;
    }

    /**
     * @return string
     */
    public static function selectConfigurationTypeById()
    {
        return self::$getTypeByIdSql;
    }

    /**
     * @return string
     */
    public static function selectConfigurationFileById()
    {
        return self::$getFileByIdSql;
    }
}