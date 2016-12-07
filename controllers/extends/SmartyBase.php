<?php

namespace controllers\bases;

abstract class SmartyBase extends HttpBase {


    protected function assign($variable, $value) {
        return \SmartyConnector::getInstance()->assign($variable, $value);
    }

    protected function display($view) {
        \SmartyConnector::getInstance()->display($view . '.tpl');
    }

    protected function renderPage($view) {
        _logNotice('Rendering view ' . $view);
        $this->display($view);
    }

    protected function renderError() {
        http_response_code(ERROR_404);
        $this->renderPage('error');
    }

}
