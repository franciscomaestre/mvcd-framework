<?php

define('BASE_PATH', realpath(dirname(dirname(__FILE__))));

require_once BASE_PATH . '/config/initial_paths.php';

$application = new \controllers\Application();
$application->run();
