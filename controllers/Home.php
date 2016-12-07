<?php

namespace controllers;

class Home extends \controllers\bases\SmartyBase{

    public function render() {
        if(\Session::exists()) {
            $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
            \Url::redirect($admin->getHome());
        } else {
            \Url::redirect('/login');
        }
    }

    public function getParamsNames() {
        return array();
    }

    public function error(){
        $this->renderError();
    }
}
