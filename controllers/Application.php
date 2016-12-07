<?php

namespace controllers;

class Application extends \controllers\bases\ApplicationBase{

    protected function getCliConfig() {

    }

    protected function getProjectConfig() {
        require_once BASE_PATH . '/config/servers.php';
        require_once BASE_PATH . '/config/grupeo-tool.php';
    }

    public function run_cli() {

    }

}
