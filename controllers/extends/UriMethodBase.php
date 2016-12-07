<?php

namespace controllers\bases;

abstract class UriMethodBase extends \controllers\bases\Base {

    protected function getMethodCalled() {
        $uriSections = \Request::getInstance()->getUriSections();
        if(!isset($uriSections[METHOD_POSITION]) || empty($uriSections[METHOD_POSITION])) {
            return DEFAULT_METHOD;
        }
        return $uriSections[METHOD_POSITION];
    }

}
