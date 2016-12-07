<?php

namespace controllers;

class Logout extends \controllers\bases\SmartyBase{

    public function render() {
        setcookie("callcenter", '', time()-36000, '/');
        \Session::finish();
        \Url::redirect('/');
    }

    public function getParamsNames() {
        return array();
    }

    public function error(){
        $this->renderError();
    }

}
