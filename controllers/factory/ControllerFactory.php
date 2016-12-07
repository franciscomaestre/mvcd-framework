<?php

namespace controllers\factory;

class ControllerFactory {

    public static function matchController() {
        $controllerClassName = self::getControllerClassName();

        if (!class_exists($controllerClassName, true)) {
            throw new \Exception('Controller not found', ERROR_404);
        }

        return new $controllerClassName();
    }

    private static function getControllerClassName() {
        $uriSections = \Request::getInstance()->getUriSections();
        if(!isset($uriSections[CONTROLLER_POSITION]) || empty($uriSections[CONTROLLER_POSITION])) {
            return CONTROLLERS_NAMESPACE . ucfirst(DEFAULT_CONTROLLER);
        }

        return CONTROLLERS_NAMESPACE . ucfirst($uriSections[CONTROLLER_POSITION]);
    }

}
