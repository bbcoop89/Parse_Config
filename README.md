# Parse_Config
Allows a consumer to parse a simple configuration file in the form: "key = value".

Run from terminal:

php parseConfig.php

The script will accept an optional "-f" option for a user-defined file path to a configuration text.

ex. php parseConfig.php -f ~/Desktop/config.txt

If this option is not used, the program will automatically use the test "config.txt" inside the project.

In order to get a configuration value by key:

$configurationMapper = new ConfigurationMapper(DatabaseSettings::getMySqlPdo());

$configValue = $configurationMapper->getByKey('debug_mode');

Sql Dump file is included.

First create the database "parse_config" and import the sql script.
