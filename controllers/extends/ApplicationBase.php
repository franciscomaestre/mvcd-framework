<?php

namespace controllers\bases;

abstract class ApplicationBase {

    public function run() {
        session_start();

        $this->getCoreLoaders();

        $this->getCorePaths();

        $this->getProjectConfig();

        $this->getCoreConfig();

        $this->debug();

        $controlador = \controllers\factory\ControllerFactory::matchController();

        echo $controlador->execute();
    }


    protected function getCoreLoaders() {
        require_once BASE_PATH . '/config/core_loaders.php';
    }

    protected function getCorePaths() {
        require_once BASE_PATH . '/config/core_paths.php';
    }

    protected function getCoreConfig() {
        if (file_exists(BASE_PATH . '/config/section.php')) {
            include BASE_PATH . '/config/section.php';

        }
        require_once BASE_PATH . '/config/core_constants.php';
        require_once BASE_PATH . '/config/cluster.php';
        require_once BASE_PATH . '/config/servers.php';
    }

    abstract protected function getProjectConfig();

    abstract public function run_cli();

    abstract protected function getCliConfig();

    protected function debug() {
        set_exception_handler('exceptionTemplate');
        if (DEBUG) {
            _logNotice('Debug Active');
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            ini_set('display_errors', 'Off');
            error_reporting(0);
        }
    }

}
