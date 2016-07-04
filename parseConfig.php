<?php

require "vendor/autoload.php";

use ParseConfig\Services\ConfigurationParsingService;
use ParseConfig\Services\FileService;

$options = getopt("f:");

if(array_key_exists("f", $options)) {
	$file = $options["f"];
} else {
	$file = 'config.txt';
}

$fileService = new FileService($file);

$parseConfigurationService = new ConfigurationParsingService($fileService);

$parseConfigurationService->getConfigurationSettings();
