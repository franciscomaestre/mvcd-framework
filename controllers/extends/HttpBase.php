<?php

namespace controllers\bases;

abstract class HttpBase extends UriMethodBase {

    /**
     * @var array
     */
    protected $params;

    function __construct() {
        $uriSections = \Request::getInstance()->getUriSections();
        $paramsUri = array_slice($uriSections, DEFAULT_PARAMS_START_POSITION);
        //This is not a magical number, we quit the empty one (0), controllers (1), method(2)
        foreach ($this->getParamsNames() as $ind => $field) {
            if (isset($paramsUri[$ind])) {
                $this->params[$field] = \Sanitizer::cleanString($paramsUri[$ind]);
            }
        }
    }

    public function execute() {
        $action = $this->getMethodCalled();

        if (!method_exists($this, $action)) {
            _logErr("Action '$action' not found, changing to 'render'");
            $action = DEFAULT_METHOD;
        }

        return $this->$action();
    }

    public function getParam($type, $nameParam, $defaultValue) {
		if(!isset($this->params[$nameParam])) {
			return \Sanitizer::defineType($type, $defaultValue);
		}
		return \Sanitizer::defineType($type, $this->params[$nameParam]);
    }

    public abstract function getParamsNames();

    public abstract function error();

}
