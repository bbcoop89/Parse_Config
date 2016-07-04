<?php

require "vendor/autoload.php";

use ParseConfig\Services\ConfigurationParsingService;
use ParseConfig\Services\FileService;

$fileService = new FileService('config.txt');

$parseConfigurationService = new ConfigurationParsingService($fileService);

$parseConfigurationService->getConfigurationSettings();
