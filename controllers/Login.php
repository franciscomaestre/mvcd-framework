<?php

namespace controllers;

class Login extends \controllers\bases\SmartyBase{
    

    public function render() {
        if(\Session::exists()) {
            $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
            \Url::redirect($admin->getHome());
        }
        $this->renderPage('login');
    }

    public function post() {

        if(!\Session::validateLimitAccessAttempt()) {
            _logWarn('Too many authentication failure');
            throw new \Exception('Too many authentication failure', 9040);
        }

        $email = \Request::getInstance()->getParamPost(\Type::$STRING, 'email', '');
        $plainPassword = \Request::getInstance()->getParamPost(\Type::$STRING, 'password', '');

        if ($email && $plainPassword) {
            _logNotice("Login admin attempt for admin '$email'");
            $this->assign('loginAttempt', true);

            $admin = \daos\internal\tool\AdminDAO::getAdminByEmailPassword($email, $plainPassword);
            if (!is_null($admin) && $admin->isActivated()){
                $this->assign('loginAttempt', true);
                $this->loginUser($admin);
            }else{
                $this->assign('loginAttempt', false);
            }
            _logDebug("login test: ".print_r($admin, true));
        } else {
            $this->assign('loginAttempt', false);
        }

        \Url::redirect('login');
    }

    /**
     * @param \models\tool\Admin $admin
     */
    private function loginUser($admin) {
        if ($admin) {
            _logDebug(sprintf("Login admin successful for admin '%s'", $admin->getEmail()));
            \Session::init($admin->getId());
            \Session::setVariable('shopId', $admin->getShopId());
            \Url::redirectCheckPoint();
        } else {
            \Session::recordAttemptAccess();
            _logNotice("Login admin failed for admin '$admin'");
            $this->assign('loginSuccess', false);
        }
    }

    public function getParamsNames() {
        return array();
    }

    public function error(){
        $this->renderError();
    }

}
