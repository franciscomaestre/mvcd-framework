<?php

namespace controllers;

use daos\external\reports\MonthlyDAO;
use models\Interval;
use models\Money;

class Summary extends \controllers\bases\AccessBase{

    public function render() {
        \Url::redirect('/summary/kpis');
    }

    public function kpisTest(){

        $initDate = isset($this->params['initDate'])?date('Y-m-d', strtotime($this->params['initDate'])):date('Y-m-d',strtotime("-1 week"));
        $endDate = isset($this->params['endDate'])?date('Y-m-d', strtotime($this->params['endDate'])):date('Y-m-d');
        $codState = (isset($this->params['codState']) && intval($this->params['codState']) == 0) ? COD_ORDERS_ALL : COD_ORDERS_PAID;

        $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
        $shop = \daos\external\shops\ShopDAO::getShopById($admin->getShopId());
        $initDateTime = new \DateTime($initDate);
        $endDateTime = new \DateTime($endDate);
        $interval = new \models\Interval($initDateTime, $endDateTime);

        $topNumber = 10;
        $this->calculateTops($admin->getShopId(), $topNumber, $codState, $interval);

        $this->assign('shop', $shop);
        $this->renderPage('summaryTest');
    }

    public function kpis() {

        $initDate = isset($this->params['initDate'])?date('Y-m-d', strtotime($this->params['initDate'])):date('Y-m-d',strtotime("-1 week"));
        $endDate = isset($this->params['endDate'])?date('Y-m-d', strtotime($this->params['endDate'])):date('Y-m-d');
        //$codState = (isset($this->params['codState']) && intval($this->params['codState']) == 0) ? COD_ORDERS_ALL : COD_ORDERS_PAID;
        $codState = COD_ORDERS_ALL;

        $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
        $shop = \daos\external\shops\ShopDAO::getShopById($admin->getShopId());
        $initDateTime = new \DateTime($initDate);
        $endDateTime = new \DateTime($endDate);
        $interval = new \models\Interval($initDateTime, $endDateTime);

        $orderReportPaid = \daos\external\reports\OrderDAO::create();
        $codOrderReportPending = \daos\external\reports\OrderDAO::create();
        $summaryReport = array();

        $this->instantiateObjects($orderReportPaid, $codOrderReportPending, $admin, $codState, $interval);
        $this->initDataSummaryReport($summaryReport);
        $this->fillDataSummaryReport($orderReportPaid, $codOrderReportPending, $summaryReport, $admin, $interval, $codState, $shop);

        $this->calculateKPIsMonths($admin, $codState, $shop);

        $this->showKPIsDays($summaryReport);

        $topNumber = 10;
        $this->calculateTops($admin->getShopId(), $topNumber, $codState, $interval);

        $this->assign('summaryReport',$summaryReport);
        $this->assign('initDate', $initDate);
        $this->assign('endDate', $endDate);
        $this->assign('codState', $codState);

        $this->assign('GRUPEO_SHOP_ID', GRUPEO_SHOP_ID);
        $this->assign('ELPAIS_SHOP_ID', ELPAIS_SHOP_ID);
        $this->assign('shop', $shop);
        $this->renderPage('summary');
    }

    public function summaryKpis() {
        $initDate = isset($this->params['initDate'])?date('Y-m-d', strtotime($this->params['initDate'])):date('Y-m-d',strtotime("-1 week"));
        $endDate = isset($this->params['endDate'])?date('Y-m-d', strtotime($this->params['endDate'])):date('Y-m-d');
        $codState = COD_ORDERS_ALL;

        $admin = \daos\internal\tool\AdminDAO::getAdminById(\Session::getId());
        $shop = \daos\external\shops\ShopDAO::getShopById($admin->getShopId());
        $initDateTime = new \DateTime($initDate);
        $endDateTime = new \DateTime($endDate);
        $interval = new \models\Interval($initDateTime, $endDateTime);

        $orderReportPaid = \daos\external\reports\OrderDAO::create();
        $codOrderReportPending = \daos\external\reports\OrderDAO::create();
        $summaryReport = array();

        $this->instantiateObjects($orderReportPaid, $codOrderReportPending, $admin, $codState, $interval);
        $this->initDataSummaryReport($summaryReport);
        $this->fillDataSummaryReport($orderReportPaid, $codOrderReportPending, $summaryReport, $admin, $interval, $codState, $shop);

        return json_encode($summaryReport);
    }

    /**
     * @param \models\reports\Order $orderReportPaid
     * @param \models\reports\Order $codOrderReportPending
     * @param \models\tool\Admin $admin
     * @param int $codState
     * @param \models\Interval $interval
     * @throws \Exception
     */
    private function instantiateObjects(&$orderReportPaid, &$codOrderReportPending, &$admin, $codState, &$interval) {

        try {
            $orderReportPaid = \daos\external\reports\OrderDAO::getDistinctOrderReportByShopIdAndStatus($admin->getShopId(), 'payed', $interval);
        } catch (\Exception $e) {
            _logDebug("There aren't Orders - ShopId: {$admin->getShopId()} | Init Date: {$interval->getInitialDate()->format("Y-m-d")} | End Date: {$interval->getEndDate()->format("Y-m-d")}");
        }

        $codOrderReportPending = \daos\external\reports\OrderDAO::create();

        if($codState == 0) {
            try {
                $codOrderReportPending = \daos\external\reports\OrderDAO::getDistinctOrderReportByShopIdAndOriginAndStatus($admin->getShopId(), 'COD', 'pending', $interval);
            } catch (\Exception $e) {
                _logDebug("There aren't COD Orders - ShopId: {$admin->getShopId()} | Init Date: {$interval->getInitialDate()->format("Y-m-d")} | End Date: {$interval->getEndDate()->format("Y-m-d")}");
            }
        }

    }

    private function initDataSummaryReport(&$summaryReport) {
        $summaryReport['paypal'] = 0;
        $summaryReport['TPV'] = 0;
        $summaryReport['COD'] = 0;
        $summaryReport['clickcanarias'] = 0;
        $summaryReport['aplazame'] = 0;
        $summaryReport['transfer'] = 0;
        $summaryReport['callcenter'] = 0;
        $summaryReport['salesDayAverage'] = 0;
        $summaryReport['salesMonthAverage'] = 0;
        $summaryReport['productQuantityDays'] = array();
        $summaryReport['newUsersQuantity'] = 0;
        $summaryReport['productQuantity'] = 0;
        $summaryReport['orderQuantity'] = 0;
        $summaryReport['totalAmountDays'] = array();
        $summaryReport['productPrice'] = new Money(0);
        $summaryReport['totalIncome'] = new Money(0);
        $summaryReport['tpvCosts'] = new Money(0);
        $summaryReport['paypalCosts'] = new Money(0);
        $summaryReport['callcenterCosts'] = new Money(0);
        $summaryReport['codCosts'] = new Money(0);
        $summaryReport['productCosts'] = new Money(0);
        $summaryReport['shippingCosts'] = new Money(0);
        $summaryReport['shippingCharges'] = new Money(0);
        $summaryReport['extraCommission'] = new Money(0);
        $summaryReport['totalCosts'] = new Money(0);
        $summaryReport['salesMargin'] = new Money(0);
        $summaryReport['advertisingPartnerMargin'] = new Money(0);
        $summaryReport['finalGrupeoMargin'] = new Money(0);
        $summaryReport['numProductOrderSavingBook'] = 0;
        $summaryReport['numProductOrderOnline'] = 0;
        $summaryReport['productPriceSavingBook'] = new Money(0);
        $summaryReport['productPriceOnline'] = new Money(0);
        $summaryReport['incomeSavingBook'] = new Money(0);
        $summaryReport['incomeOnline'] = new Money(0);
        $summaryReport['percenOrderSavingBook'] = 0;
        $summaryReport['percenOrderOnline'] = 0;
        $summaryReport['percenIncomeOrderSavingBook'] = 0;
        $summaryReport['percenIncomeOrderOnline'] = 0;
        $summaryReport['daysRangesShoppingBasket'] = array();
        $summaryReport['averageShoppingBasketDay'] = array();
        $summaryReport['valueAverageShoppingBasket'] = new Money(0);
    }

    /**
     * @param \models\reports\Order $orderReport
     * @param \models\reports\Order $codOrderReportPending
     * @param array $summaryReport
     * @param \models\tool\Admin $admin
     * @param \models\Interval $interval
     * @param \models\shops\Shop $shop
     * @param int $codState
     */
    private function fillDataSummaryReport(&$orderReport, &$codOrderReportPending, &$summaryReport, &$admin, &$interval, $codState, &$shop) {
        if($orderReport->hasLines()) {
            foreach ($orderReport->getLines() as $orderReportLine) {
                $summaryReport['orderQuantity'] ++;
                $summaryReport[$orderReportLine->getOrigin()]++;

                $extraCommission = $summaryReport['extraCommission']->getValueInCents() + $orderReportLine->getExtraCommission()->getValueInCents();
                $summaryReport['extraCommission'] = new Money($extraCommission);

                if($orderReportLine->getCallcenter() == 1) {
                    $summaryReport['callcenter']++;
                }
                $this->addQuantitiesProductsReport($summaryReport, $orderReportLine, $admin, $interval, $shop);
            }
        }

        if($codState == 0 && $codOrderReportPending && $codOrderReportPending->hasLines()) {
            foreach($codOrderReportPending->getLines() as $codOrderReportPendingLine) {
                $summaryReport['orderQuantity'] ++;
                $summaryReport[$codOrderReportPendingLine->getOrigin()]++;

                $extraCommission = $summaryReport['extraCommission']->getValueInCents() + $codOrderReportPendingLine->getExtraCommission()->getValueInCents();
                $summaryReport['extraCommission'] = new Money($extraCommission);

                if($codOrderReportPendingLine->getCallcenter() == 1) {
                    $summaryReport['callcenter']++;
                }
                $this->addQuantitiesProductsReport($summaryReport, $codOrderReportPendingLine, $admin, $interval, $shop);
            }
        }

        $summaryReport['orderQuantity'] = $summaryReport['TPV'] + $summaryReport['COD'] + $summaryReport['paypal'] + $summaryReport['transfer'] + $summaryReport['clickcanarias'] + $summaryReport['aplazame'];

        $this->calculateNewUsersQuantity($summaryReport, $admin->getShopId(), $interval);

        $diffDate = $interval->getInitialDate()->diff($interval->getEndDate());
        $summaryReport['salesDayAverage'] = number_format($summaryReport['productQuantity']/($diffDate->days + 1), 2, '.', '');
        $this->calculateCosts($summaryReport, $admin->getShopId(), $interval);

        $summaryReport['totalIncome'] = new Money($summaryReport['productPrice']->getValueInCents() + $summaryReport['shippingCharges']->getValueInCents() + $summaryReport['extraCommission']->getValueInCents());
        $this->calculateMargins($summaryReport, $admin->getShopId());

        $totalProductReports = $summaryReport['numProductOrderSavingBook'] + $summaryReport['numProductOrderOnline'];
        if($totalProductReports > 0) {
            $summaryReport['percenOrderSavingBook'] = number_format(($summaryReport['numProductOrderSavingBook'] / $totalProductReports) * 100, 2, '.', '');
            $summaryReport['percenOrderOnline'] = number_format(($summaryReport['numProductOrderOnline'] / $totalProductReports) * 100, 2, '.', '');
        }

        $totalIncome = $summaryReport['incomeSavingBook']->getValueInCents() + $summaryReport['incomeOnline']->getValueInCents();
        if($totalIncome > 0) {
            $summaryReport['percenIncomeOrderSavingBook'] = number_format(($summaryReport['incomeSavingBook']->getValueInCents() / $totalIncome) * 100, 2, '.', '');
            $summaryReport['percenIncomeOrderOnline'] = number_format(($summaryReport['incomeOnline']->getValueInCents() / $totalIncome) * 100, 2, '.', '');
        }

        $this->calculateAverageShoppingBasket($summaryReport, $interval, $shop);
    }

    /**
     * @param [] $summaryReport
     * @param \models\reports\OrderLine $orderReport
     * @param \models\tool\Admin $admin
     * @param \models\Interval $interval
     */
    private function addQuantitiesProductsReport(&$summaryReport, &$orderReport, &$admin, \models\Interval &$interval, &$shop) {
        try{
            $productReport = \daos\external\reports\ProductDAO::getProductReportByOrderId($orderReport->getOrderId(), $interval);
            $this->calculateQuantitiesProductReport($summaryReport, $admin, $orderReport, $productReport, $shop);
        } catch (\Exception $e) {
            _logDebug("There aren't Products - Order: {$orderReport->getId()}");
        }
    }

    /**
     * @param array $summaryReport
     * @param \models\Interval $interval
     * @param \models\shops\Shop $shop
     */
    private function calculateAverageShoppingBasket(&$summaryReport, &$interval, &$shop) {

        $dailyBigBrother = \daos\external\bigBrother\DailyDAO::getDailyByShopId($shop->getId(), $interval);
        if($dailyBigBrother->hasLines()) {
            $numDaysShoppingBasket = 0;
            $sumValueShoppingBasket = 0;
            foreach($dailyBigBrother->getLines() as $line) {
                if($line->getTotalAmountOrders()->getValueInCents() > 0 && $line->getOrdersQuantity() > 0) {
                    $value = $line->getTotalAmountOrders()->getValueInCents() / $line->getOrdersQuantity();
                } else {
                    $value = 0;
                }
                $summaryReport['averageShoppingBasketDay'][$line->getDate()->format('Y-m-d')] = new \models\Money($value);
                $numDaysShoppingBasket++;
                $sumValueShoppingBasket += $value;
            }
            if($numDaysShoppingBasket > 0) {
                $summaryReport['valueAverageShoppingBasket'] = new \models\Money($sumValueShoppingBasket/$numDaysShoppingBasket);
            }
        }

    }


    /**
     * @param \models\tool\Admin $admin
     * @param \models\reports\OrderLine $orderReportLine
     * @param \models\reports\Product $productReport
     * @param \models\shops\Shop $shop
     * @return int
     */
    private function calculateQuantitiesProductReport(&$summaryReport, &$admin, &$orderReportLine, &$productReport, &$shop){
        if($productReport->hasLines()){

            $this->addShippingCharges($summaryReport,$orderReportLine);
            foreach ($productReport->getLines() as $productReportLine) {

                $lineWeight = $this->calculateLineWeight($productReport, $productReportLine);
                $productPriceInCents = $productReportLine->getSalePrice()->getValueInCents() * $productReportLine->getQuantity();
                $shippingCharges = $orderReportLine->getShippingCharges()->getValueInCents() * $lineWeight;

                if($productReportLine->getSavingBook() == 0 || $shop->getSeparateSavingBook() == 0) {
                    $this->calculateQuantityAndPriceDays($summaryReport, $productReportLine);
                    $summaryReport['productQuantity'] += $productReportLine->getQuantity();
                    $previousProductPriceInCents = $summaryReport['productPrice']->getValueInCents();
                    $summaryReport['productPrice'] = new Money($previousProductPriceInCents + $productPriceInCents);

                    $newValueShippingCharges = $summaryReport['shippingCharges']->getValueInCents() + $shippingCharges;
                    $summaryReport['shippingCharges'] = new Money($newValueShippingCharges);
                }

                $extraCommissionsSavingBook = $orderReportLine->getExtraCommission()->getValueInCents() * $lineWeight;

                if($productReportLine->getSavingBook() == 1) {
                    if($shop->getSeparateSavingBook() == 0) {
                        $summaryReport['numProductOrderSavingBook']++;
                        $previousPriceSavingBook = $summaryReport['incomeSavingBook']->getValueInCents();
                        $incomeSavingBook = $productPriceInCents + $shippingCharges + $extraCommissionsSavingBook;
                        $summaryReport['incomeSavingBook'] = new Money($previousPriceSavingBook + $incomeSavingBook);
                    }
                } else {
                    $summaryReport['numProductOrderOnline']++;
                    $previousPriceOnline = $summaryReport['incomeOnline']->getValueInCents();
                    $incomeOnline = $productPriceInCents + $shippingCharges + $extraCommissionsSavingBook;
                    $summaryReport['incomeOnline'] = new Money($previousPriceOnline + $incomeOnline);
                }
            }
        }
    }

    /**
     * @param array $summaryReport
     * @param \models\reports\OrderLine $orderReportLine
     */
    private function addShippingCharges(&$summaryReport, &$orderReportLine){
        $shippingChargesInCents = $orderReportLine->getShippingCharges()->getValueInCents();
        if (isset($summaryReport['totalAmountDays'][$orderReportLine->getDate()->format('Y-m-d')])) {
            $previousPrice = $summaryReport['totalAmountDays'][$orderReportLine->getDate()->format('Y-m-d')]->getValueInCents();
            $summaryReport['totalAmountDays'][$orderReportLine->getDate()->format('Y-m-d')] = new Money($shippingChargesInCents+$previousPrice);
        } else {
            $summaryReport['totalAmountDays'][$orderReportLine->getDate()->format('Y-m-d')] = new Money($shippingChargesInCents);
        }
    }

    /**
     * @param \models\reports\Product $productReport
     * @param \models\reports\ProductLine $productReportLine
     * @return float
     */
    private function calculateLineWeight(&$productReport, &$productReportLine) {
        $price = $productReportLine->getSalePrice()->getValueInCents() * $productReportLine->getQuantity();
        $pricesProductReport = 0;
        foreach ($productReport->getLines() as $productLine) {
            $pricesProductReport += $productLine->getSalePrice()->getValueInCents() * $productLine->getQuantity();
        }
        if ($pricesProductReport==0) {
            return 0;
        }
        return $price / $pricesProductReport;
    }

    /**
     * @param $summaryReport
     * @param \models\reports\ProductLine $productReportLine
     */
    private function calculateQuantityAndPriceDays(&$summaryReport, &$productReportLine) {

        if( isset($summaryReport['productQuantityDays'][$productReportLine->getDate()->format('Y-m-d')]) ) {
            $summaryReport['productQuantityDays'][$productReportLine->getDate()->format('Y-m-d')] += $productReportLine->getQuantity();
        } else {
            $summaryReport['productQuantityDays'][$productReportLine->getDate()->format('Y-m-d')] = $productReportLine->getQuantity();
        }

        $productPriceInCents = $productReportLine->getSalePrice()->getValueInCents() * $productReportLine->getQuantity();
        if( isset($summaryReport['totalAmountDays'][$productReportLine->getDate()->format('Y-m-d')]) ) {
            $previousPrice = $summaryReport['totalAmountDays'][$productReportLine->getDate()->format('Y-m-d')]->getValueInCents();
            $summaryReport['totalAmountDays'][$productReportLine->getDate()->format('Y-m-d')] = new Money($previousPrice + $productPriceInCents);
        } else {
            $summaryReport['totalAmountDays'][$productReportLine->getDate()->format('Y-m-d')] = new Money($productPriceInCents);
        }
    }

    private function calculateCosts(&$summaryReport, $shopId, &$interval) {

        $economicReport = \daos\external\reports\EconomicDAO::getEconomicReportByShopId($shopId, $interval);

        if($economicReport->hasLines()) {
            foreach($economicReport->getLines() as $economicReportLine) {
                $costInCents = -$economicReportLine->getAmount()->getValueInCents();
                if(strpos($economicReportLine->getConcept(),'Paypal') !== false) {
                    $amountInCents = $summaryReport['paypalCosts']->getValueInCents() + $costInCents;
                    $summaryReport['paypalCosts'] = new Money($amountInCents);
                } else if (strpos($economicReportLine->getConcept(),'shipping') !== false) {
                    $amountInCents = $summaryReport['shippingCosts']->getValueInCents() + $costInCents;
                    $summaryReport['shippingCosts'] =  new Money($amountInCents);
                } else if (strpos($economicReportLine->getConcept(),'COD') !== false) {
                    $amountInCents = $summaryReport['codCosts']->getValueInCents() + $costInCents;
                    $summaryReport['codCosts'] =  new Money($amountInCents);
                } else if (strpos($economicReportLine->getConcept(),'Callcenter costs') !== false) {
                    $amountInCents = $summaryReport['callcenterCosts']->getValueInCents() + $costInCents;
                    $summaryReport['callcenterCosts'] =  new Money($amountInCents);
                } else if (strpos($economicReportLine->getConcept(),'product') !== false) {
                    $amountInCents = $summaryReport['productCosts']->getValueInCents() + $costInCents;
                    $summaryReport['productCosts'] =  new Money($amountInCents);
                } else if (strpos($economicReportLine->getConcept(),'TPV') !== false) {
                    $amountInCents = $summaryReport['tpvCosts']->getValueInCents() + $costInCents;
                    $summaryReport['tpvCosts'] =  new Money($amountInCents);
                }
            }
        }

        $totalCostInCents = $summaryReport['paypalCosts']->getValueInCents() +
            $summaryReport['tpvCosts']->getValueInCents() + $summaryReport['callcenterCosts']->getValueInCents() +
            $summaryReport['codCosts']->getValueInCents() + $summaryReport['productCosts']->getValueInCents() +
            $summaryReport['shippingCosts']->getValueInCents();

        $summaryReport['totalCosts'] = new Money($totalCostInCents);
    }

    private function calculateMargins(&$summaryReport, $shopId) {
        $shopCommission = $this->calculateShopCommission($shopId, $summaryReport['productPrice']);
        if($shopId == 2) {
            $marginInCents = $summaryReport['productPrice']->getValueInCents() - $summaryReport['paypalCosts']->getValueInCents() -
                $summaryReport['tpvCosts']->getValueInCents() - $summaryReport['callcenterCosts']->getValueInCents() -
                $summaryReport['productCosts']->getValueInCents();
            $totalCostInCents = $summaryReport['paypalCosts']->getValueInCents() +
                $summaryReport['tpvCosts']->getValueInCents() + $summaryReport['callcenterCosts']->getValueInCents() +
                $summaryReport['productCosts']->getValueInCents();

            $summaryReport['totalCosts'] = new Money($totalCostInCents);
            $grupeoMarginInCents = $marginInCents * $shopCommission;
            $summaryReport['salesMargin'] = new Money($marginInCents);
            $extraGrupeoMargin = $summaryReport['shippingCharges']->getValueInCents() - $summaryReport['shippingCosts']->getValueInCents();
            $summaryReport['advertisingPartnerMargin'] = new Money($marginInCents - $grupeoMarginInCents);
            $summaryReport['finalGrupeoMargin'] = new Money($grupeoMarginInCents + $extraGrupeoMargin);
        } else {
            $marginInCents = $summaryReport['totalIncome']->getValueInCents() - $summaryReport['totalCosts']->getValueInCents();
            $grupeoMarginInCents = $marginInCents * $shopCommission;
            $summaryReport['salesMargin'] = new Money($marginInCents);
            $summaryReport['advertisingPartnerMargin'] = new Money($marginInCents - $grupeoMarginInCents);
            $summaryReport['finalGrupeoMargin'] = new Money($grupeoMarginInCents);
        }

    }

    private function calculateShopCommission($shopId, $productPrice) {
        $commission = \daos\external\shops\GrupeoCommissionDAO::getGrupeoCommissionByShopIdAndAmount($shopId,$productPrice);
        $shopCommission = 0;
        foreach ($commission->getLines() as $commissionLine){
            $shopCommission = $commissionLine->getPercentage();
        }
        return $shopCommission/100;
    }

    private function calculateNewUsersQuantity(&$summaryReport, $shopId, &$interval) {
        $dailyBigBrother = \daos\external\bigBrother\DailyDAO::getDailyByShopId($shopId, $interval);

        if($dailyBigBrother->hasLines()) {
            foreach($dailyBigBrother->getLines() as $dailyLine) {
                $summaryReport['newUsersQuantity'] += $dailyLine->getNewUsersQuantity();
            }
        }
    }

    private function showKPIsDays(&$summaryReport) {
        $summaryReport['percenOrderSavingBook'] = $summaryReport['percenOrderSavingBook'] . '%';
        $summaryReport['percenOrderOnline'] = $summaryReport['percenOrderOnline'] . '%';

        $summaryReport['percenIncomeOrderSavingBook'] = $summaryReport['percenIncomeOrderSavingBook'] . '%';
        $summaryReport['percenIncomeOrderOnline'] = $summaryReport['percenIncomeOrderOnline'] . '%';

        $summaryReport['daysRanges'] = array_keys($summaryReport['totalAmountDays']);
        $summaryReport['totalAmountDays'] = array_values($summaryReport['totalAmountDays']);
        $summaryReport['productQuantityDays'] = array_values($summaryReport['productQuantityDays']);
        $summaryReport['daysRangesShoppingBasket'] = array_keys($summaryReport['averageShoppingBasketDay']);
        $summaryReport['averageShoppingBasketDay'] = array_values($summaryReport['averageShoppingBasketDay']);
    }

    /**
     * @param \models\tool\Admin $admin
     * @param int $codState
     * @param \models\shops\Shop $shop
     */
    private function calculateKPIsMonths(&$admin, $codState, &$shop) {
        $firstOrderReport = \daos\external\reports\OrderLineDAO::getFirstOrderReportLineByShopIdAndStatus($admin->getShopId(), 'payed');

        $firstDateShop = $firstOrderReport->getDate();
        $yearFirstDateShop = intval($firstDateShop->format('Y'));
        $monthFirstDateShop = intval($firstDateShop->format('m'));

        $currentDate = new \DateTime();
        $currentYear = intval($currentDate->format('Y'));
        $currentMonth = intval($currentDate->format('m'));
        $initialMonth = $monthFirstDateShop;
        $endMonth = 12;

        $summaryMonthlyReport = array();
        $this->initDataSummaryReportMonths($summaryMonthlyReport);

        for($year = $yearFirstDateShop; $year <= $currentYear; ) {
            for($month = $initialMonth; $month <= $endMonth; $month++) {
                $monthlyReport = \daos\external\reports\MonthlyDAO::getMonthlyReportByShopIdAndYearAndMonth($shop->getId(), $year,$month);
                $monthlyBigBrother = \daos\external\bigBrother\MonthlyLineDAO::getMonthlyLineByShopIdAndYearAndMonth($shop->getId(), $year,$month);
                $dateMonth = new \DateTime("{$year}-{$month}-01");
                $this->fillSummaryMonthlyReport($dateMonth, $summaryMonthlyReport, $shop, $monthlyReport, $monthlyBigBrother);
            }
            $initialMonth = 1;
            $year++;
            $endMonth = ($year == $currentYear) ? $currentMonth : 12;
        }

        $diffDate = $firstDateShop->diff($currentDate);
        $numberMonths = ($diffDate->m + ($diffDate->y * 12)) + 1;
        $summaryMonthlyReport['salesMonthAverage'] = number_format($summaryMonthlyReport['totalProductQuantity']/($numberMonths), 2, '.', '');

        $this->calculateGrowthRate($summaryMonthlyReport);

        $this->calculateGrowRateUsers($summaryMonthlyReport);

        $this->showKPIsMonths($summaryMonthlyReport);
    }
    /**
     * @param $dateMonth
     * @param $summaryMonthlyReport
     * @param \models\shops\Shop $shop
     * @param \models\reports\Monthly $monthlyReport
     * @param \models\bigBrother\MonthlyLine $monthlyBigBrother
     */
    private function fillSummaryMonthlyReport($dateMonth, &$summaryMonthlyReport, &$shop, &$monthlyReport, &$monthlyBigBrother) {

        if(!$shop->getSeparateSavingBook()) {
            $this->fillSummaryMonthlyReportShopWithoutSeparateSavingBook($dateMonth, $summaryMonthlyReport, $shop, $monthlyReport);
        } else {
            $this->fillSummaryMonthlyReportShopSeparateSavingBook($dateMonth, $summaryMonthlyReport, $shop, $monthlyReport);
        }

        $summaryMonthlyReport['numUsersMonth'][$dateMonth->format('Y-m-d')] =  $monthlyBigBrother->getNewUsersQuantity();
        if($monthlyBigBrother->getOrdersQuantity() > 0 && $monthlyBigBrother->getUserOrdersQuantity() > 0) {
            $summaryMonthlyReport['averageShoppingMonth'][$dateMonth->format('Y-m-d')] =  number_format($monthlyBigBrother->getOrdersQuantity() / $monthlyBigBrother->getUserOrdersQuantity(), 2);
        } else {
            $summaryMonthlyReport['averageShoppingMonth'][$dateMonth->format('Y-m-d')] = 0;
        }

        if($monthlyBigBrother->getTotalAmountOrders()->getValueInCents() > 0 && $monthlyBigBrother->getOrdersQuantity() > 0) {
            $value = $monthlyBigBrother->getTotalAmountOrders()->getValueInCents() / $monthlyBigBrother->getOrdersQuantity();
        } else {
            $value = 0;
        }
        $summaryMonthlyReport['averageShoppingBasketMonth'][$dateMonth->format('Y-m-d')] =  new \models\Money($value);
    }

    private function fillSummaryMonthlyReportShopWithoutSeparateSavingBook($dateMonth, &$summaryMonthlyReport, &$shop, &$monthlyReport) {
        $summaryMonthlyReport['totalProductQuantity'] += $monthlyReport->getProductQuantity();
        $summaryMonthlyReport['productQuantityMonth'][$dateMonth->format('Y-m-d')] = $monthlyReport->getProductQuantity();
        $summaryMonthlyReport['totalAmountMonth'][$dateMonth->format('Y-m-d')] = $monthlyReport->getTotalAmount();

        $salesMargin = $monthlyReport->getTotalAmount()->getValueInCents() - $monthlyReport->getTotalCost()->getValueInCents();
        $commission =  (1 - $this->calculateShopCommission($shop->getId(), $monthlyReport->getTotalProductPrice()));
        $summaryMonthlyReport['salesMarginMonth'][$dateMonth->format('Y-m-d')] = new Money($salesMargin * $commission);

        $this->calculateAccumulatedMarginShop($summaryMonthlyReport, $dateMonth, $shop);

        $totalOrder = $monthlyReport->getOrderQuantitySavingBook() + $monthlyReport->getOrderQuantityOnline();
        if($totalOrder == 0) {
            $summaryMonthlyReport['percenOrderSavingBookMonth'][$dateMonth->format('Y-m-d')] = 0;
            $summaryMonthlyReport['percenOrderOnlineMonth'][$dateMonth->format('Y-m-d')] = 0;
            $summaryMonthlyReport['percenIncomeOrderSavingBookMonth'][$dateMonth->format('Y-m-d')] = 0;
            $summaryMonthlyReport['percenIncomeOrderOnlineMonth'][$dateMonth->format('Y-m-d')] = 0;
        } else {
            $summaryMonthlyReport['percenOrderSavingBookMonth'][$dateMonth->format('Y-m-d')] = number_format(($monthlyReport->getOrderQuantitySavingBook() / $totalOrder) * 100, 2);
            $summaryMonthlyReport['percenOrderOnlineMonth'][$dateMonth->format('Y-m-d')] = number_format(($monthlyReport->getOrderQuantityOnline() / $totalOrder) * 100, 2);
            $summaryMonthlyReport['percenIncomeOrderSavingBookMonth'][$dateMonth->format('Y-m-d')] = number_format(($monthlyReport->getTotalAmountSavingBook()->getValueInCents() / $monthlyReport->getTotalAmount()->getValueInCents()) * 100, 2);
            $summaryMonthlyReport['percenIncomeOrderOnlineMonth'][$dateMonth->format('Y-m-d')] = number_format(($monthlyReport->getTotalAmountOnline()->getValueInCents() / $monthlyReport->getTotalAmount()->getValueInCents())*100, 2);
        }

        $summaryMonthlyReport['incomeSavingBookMonth'][$dateMonth->format('Y-m-d')] = $monthlyReport->getTotalAmountSavingBook();
        $summaryMonthlyReport['incomeOnlineMonth'][$dateMonth->format('Y-m-d')] = $monthlyReport->getTotalAmountOnline();
    }

    private function fillSummaryMonthlyReportShopSeparateSavingBook($dateMonth, &$summaryMonthlyReport, &$shop, &$monthlyReport) {
        $summaryMonthlyReport['totalProductQuantity'] += $monthlyReport->getProductQuantity() - $monthlyReport->getProductQuantitySavingBook();
        $summaryMonthlyReport['productQuantityMonth'][$dateMonth->format('Y-m-d')] = $monthlyReport->getProductQuantity() - $monthlyReport->getProductQuantitySavingBook();
        $summaryMonthlyReport['totalAmountMonth'][$dateMonth->format('Y-m-d')] = $monthlyReport->getTotalAmountOnline();

        $valueProductPriceOnline = $monthlyReport->getTotalProductPrice()->getValueInCents() - $monthlyReport->getTotalProductPriceSavingBook()->getValueInCents();
        $totalCostOnline = $monthlyReport->getTotalCost()->getValueInCents() - $monthlyReport->getTotalCostSavingBook()->getValueInCents();
        if($shop->getId() == AS_SHOP_ID){
            $salesMargin = $valueProductPriceOnline - $totalCostOnline;
        } else {
            $salesMargin = $monthlyReport->getTotalAmountOnline()->getValueInCents() - $totalCostOnline;
        }

        $productPrice = new \models\Money($valueProductPriceOnline);
        $commission =  (1 - $this->calculateShopCommission($shop->getId(), $productPrice));
        $summaryMonthlyReport['salesMarginMonth'][$dateMonth->format('Y-m-d')] = new Money($salesMargin * $commission);

        $this->calculateAccumulatedMarginShop($summaryMonthlyReport, $dateMonth, $shop);

        $summaryMonthlyReport['percenOrderSavingBookMonth'][$dateMonth->format('Y-m-d')] = 0;
        $summaryMonthlyReport['percenOrderOnlineMonth'][$dateMonth->format('Y-m-d')] = 100;
        $summaryMonthlyReport['percenIncomeOrderSavingBookMonth'][$dateMonth->format('Y-m-d')] = 0;
        $summaryMonthlyReport['percenIncomeOrderOnlineMonth'][$dateMonth->format('Y-m-d')] = 100;
        $summaryMonthlyReport['incomeSavingBookMonth'][$dateMonth->format('Y-m-d')] = new Money(0);
        $summaryMonthlyReport['incomeOnlineMonth'][$dateMonth->format('Y-m-d')] = $monthlyReport->getTotalAmountOnline();
    }

    private function initDataSummaryReportMonths(&$summaryMonthlyReport) {
        $summaryMonthlyReport['totalProductQuantity'] = 0;
        $summaryMonthlyReport['productQuantityMonth'] = array();
        $summaryMonthlyReport['totalAmountMonth'] = array();
        $summaryMonthlyReport['salesMarginMonth'] = array();
        $summaryMonthlyReport['salesMarginAccumulatedMonth'] = array();
        $summaryMonthlyReport['growthRateMonth'] = array();
        $summaryMonthlyReport['numUsersMonth'] = array();
        $summaryMonthlyReport['growthRateMonthUsers'] = array();
        $summaryMonthlyReport['averageShoppingMonth'] = array();
        $summaryMonthlyReport['averageShoppingBasketMonth'] = array();
        $summaryMonthlyReport['percenOrderSavingBookMonth'] = array();
        $summaryMonthlyReport['percenOrderOnlineMonth'] = array();
        $summaryMonthlyReport['percenIncomeOrderSavingBookMonth'] = array();
        $summaryMonthlyReport['percenIncomeOrderOnlineMonth'] = array();
        $summaryMonthlyReport['incomeSavingBookMonth'] = array();
        $summaryMonthlyReport['incomeOnlineMonth'] = array();
    }

    private function showKPIsMonths(&$summaryMonthlyReport) {
        $summaryMonthlyReport['monthsRanges'] = array_keys($summaryMonthlyReport['productQuantityMonth']);
        $summaryMonthlyReport['productQuantityMonth'] = array_values($summaryMonthlyReport['productQuantityMonth']);
        $summaryMonthlyReport['totalAmountMonth'] = array_values($summaryMonthlyReport['totalAmountMonth']);
        $summaryMonthlyReport['salesMarginMonth'] = array_values($summaryMonthlyReport['salesMarginMonth']);
        $summaryMonthlyReport['monthsRangesAccumulatedMargin'] = array_keys($summaryMonthlyReport['salesMarginAccumulatedMonth']);
        $summaryMonthlyReport['salesMarginAccumulatedMonth'] = array_values($summaryMonthlyReport['salesMarginAccumulatedMonth']);
        $summaryMonthlyReport['growthRateMonth'] = array_values($summaryMonthlyReport['growthRateMonth']);
        $summaryMonthlyReport['numUsersMonth'] = array_values($summaryMonthlyReport['numUsersMonth']);
        $summaryMonthlyReport['growthRateMonthUsers'] = array_values($summaryMonthlyReport['growthRateMonthUsers']);
        $summaryMonthlyReport['averageShoppingMonth'] = array_values($summaryMonthlyReport['averageShoppingMonth']);
        $summaryMonthlyReport['averageShoppingBasketMonth'] = array_values($summaryMonthlyReport['averageShoppingBasketMonth']);
        $summaryMonthlyReport['percenOrderOnlineMonth'] = array_values($summaryMonthlyReport['percenOrderOnlineMonth']);
        $summaryMonthlyReport['percenOrderSavingBookMonth'] = array_values($summaryMonthlyReport['percenOrderSavingBookMonth']);
        $summaryMonthlyReport['percenIncomeOrderSavingBookMonth'] = array_values($summaryMonthlyReport['percenIncomeOrderSavingBookMonth']);
        $summaryMonthlyReport['percenIncomeOrderOnlineMonth'] = array_values($summaryMonthlyReport['percenIncomeOrderOnlineMonth']);
        $summaryMonthlyReport['incomeSavingBookMonth'] = array_values($summaryMonthlyReport['incomeSavingBookMonth']);
        $summaryMonthlyReport['incomeOnlineMonth'] = array_values($summaryMonthlyReport['incomeOnlineMonth']);

        $this->assign('summaryReportMonth', $summaryMonthlyReport);
    }

    private function calculateAccumulatedMarginShop(&$summaryMonthlyReport, &$dateMonth, &$shop) {
        if($shop->getId() == ELPAIS_SHOP_ID) {
            if(intval($dateMonth->format('Y')) == 2016) {
                $this->calculateAccumulatedMargin($summaryMonthlyReport, $dateMonth);
            }
        } else {
            $this->calculateAccumulatedMargin($summaryMonthlyReport, $dateMonth);
        }
    }

    private function calculateAccumulatedMargin(&$summaryMonthlyReport, &$dateMonth) {
        $marginValueMonth = $summaryMonthlyReport['salesMarginMonth'][$dateMonth->format('Y-m-d')]->getValueInCents();
        $date = new \DateTime($dateMonth->format('Y-m-d'));
        $date->modify('-1 month');
        if(isset($summaryMonthlyReport['salesMarginAccumulatedMonth'][$date->format('Y-m-d')])) {
            $previousValue = $summaryMonthlyReport['salesMarginAccumulatedMonth'][$date->format('Y-m-d')]->getValueInCents();
            $summaryMonthlyReport['salesMarginAccumulatedMonth'][$dateMonth->format('Y-m-d')] = new \models\Money($previousValue + $marginValueMonth);
        } else {
            $summaryMonthlyReport['salesMarginAccumulatedMonth'][$dateMonth->format('Y-m-d')] = $summaryMonthlyReport['salesMarginMonth'][$dateMonth->format('Y-m-d')];
        }
    }

    private function calculateGrowthRate(&$summaryMonthlyReport) {
        $previousMargin = 0;
        foreach($summaryMonthlyReport['salesMarginMonth'] as $month => $margin) {
            if($previousMargin == 0) {
                $summaryMonthlyReport['growthRateMonth'][$month] = 0;
            } else {
                $summaryMonthlyReport['growthRateMonth'][$month] = number_format((($summaryMonthlyReport['salesMarginMonth'][$month]->getValueInCents() - $previousMargin)/$previousMargin)*100, 2, '.', '');
            }
            $previousMargin = $margin->getValueInCents();
        }
    }

    private function calculateGrowRateUsers(&$summaryMonthlyReport) {
        $previousNumUsers = 0;
        foreach($summaryMonthlyReport['numUsersMonth'] as $month => $numUsers) {
            if($previousNumUsers == 0) {
                $summaryMonthlyReport['growthRateMonthUsers'][$month] = 0;
            } else {
                $summaryMonthlyReport['growthRateMonthUsers'][$month] = number_format((($summaryMonthlyReport['numUsersMonth'][$month] - $previousNumUsers)/$previousNumUsers)*100, 2, '.', '');
            }
            $previousNumUsers = $numUsers;
        }
    }


    private function calculateTops($shopId, $topNumber, $codState, &$interval) {
        $this->assignTopCategory($shopId,$topNumber, $codState, $interval);
        $this->assignTopProduct($shopId,$topNumber, $codState, $interval);
    }

    private function assignTopCategory($shopId, $topNumber, $codState, $interval) {
        $topCategory = \daos\internal\bigBrother\TopCategoryDAO::getTopCategoryByShopIdAndTopNumberAndCodState($shopId, $topNumber, $codState, $interval);
        $this->assign('topCategory', $topCategory);
    }

    private function assignTopProduct($shopId, $topNumber, $codState, $interval) {
        $topProduct = \daos\internal\bigBrother\TopProductDAO::getTopProductByShopIdAndTopNumberAndCodState($shopId, $topNumber, $codState, $interval);
        $this->assign('topProduct', $topProduct);
    }

    public function getParamsNames() {
        return array('initDate', 'endDate', 'codState');
    }

    public function error(){
        $this->renderError();
    }

}
