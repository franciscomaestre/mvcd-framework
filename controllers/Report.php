<?php

namespace controllers;

use models\shops\Shop;

class Report extends \controllers\bases\SmartyBase{

    public function render() {
        $this->report();
    }

    public function report(){
        try {
            $this->getParametersReport($shop, $date, $codStatus);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $orderReport = \daos\external\reports\OrderDAO::getOrderReportByShopId($shop->getId(),$date);

        $this->configureReport($date,$codStatus,$orderReport,$shop);

        $this->renderPage('report');
    }

    /**
     * @param \models\shops\Shop $shop
     * @param \models\Interval $date
     * @param int $codStatus
     * @throws \Exception
     */
    private function getParametersReport(&$shop, &$date, &$codStatus){
        try {
            $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $shopId = $admin->getShopId();
        $shop = \daos\external\shops\ShopDAO::getShopById($shopId);
        $initialDate = isset($this->params[1]) ? new \DateTime(date('Y-m-d', strtotime($this->params[1]))) : new \DateTime(date('Y-m-d',strtotime("-1 week")));
        $endDate = isset($this->params[2]) ? new \DateTime(date('Y-m-d', strtotime($this->params[2]))) : new \DateTime(date('Y-m-d'));
        $date = new \models\Interval($initialDate,$endDate);
        $codStatus = (isset($this->params[3]) && intval($this->params[3]) == 0) ? COD_ALL : COD_PAYED;
    }

    private function configureReport($date,$codStatus,$orderReport,$shop){

        $this->assign('date', $date);
        $this->assign('codStatus', $codStatus);
        $this->assign('order', $orderReport);
        $this->assign('shop', $shop);
    }

    public function getParamsNames() {
        return array(1,2,3);
    }

    public function error(){
        $this->renderError();
    }

}
