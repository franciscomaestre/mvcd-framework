<?php

namespace controllers;

class Shops extends \controllers\bases\AccessBase{

    public function render() {
        $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
        \Url::redirect($admin->getHome());
    }
    
    public function change() {
        
        $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
        $selectedShopId = \Request::getInstance()->getParamPost(\Type::$INT, 'shopId', $admin->getShopId());
        $result = false;
        if(in_array($selectedShopId, $admin->getAllowedShopsId())) {
            $admin->setShopId($selectedShopId);
            $result=\daos\internal\tool\AdminDAO::updateAdmin($admin);
        }
        return json_encode(['result' => $result]);
    }
    

    public function getParamsNames() {
        return array('shopId');
    }

    public function error(){
        $this->renderError();
    }
}
