<?php

namespace controllers\bases;

abstract class AccessBase extends \controllers\bases\SmartyBase {

    function __construct() {
        parent::__construct();

        if (!\Session::exists()) {
            \Url::setCheckPoint(\Request::getInstance()->getUri());
            \Url::redirect('/login');
        }
        
        $parts = explode('\\',get_class($this));
        $className = array_pop($parts);
        $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
        if(strpos($admin->getAllowedControllers(), $className) === false) {
            \Url::redirect($admin->getHome());
        }
        

    }
    
    protected function renderPage($view) {
        $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
        $allowedShops = $admin->getAllowedShops();
        $shopsCounter = count($allowedShops);
        if($shopsCounter>1) {
           $this->assign('adminShop', $admin->getShop());
           $this->assign('allowedShops', $allowedShops); 
        }
        $this->display($view);
    }
    
}
