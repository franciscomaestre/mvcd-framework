<?php

namespace controllers\bases;

abstract class Base {

    abstract function execute();

    function __call($name, $arguments = array()) {
        _logErr("Method not found $name : whit params ".  print_r($arguments,true));
        throw new \Exception('Controller Method Not Found', ERROR_404);
    }

}
