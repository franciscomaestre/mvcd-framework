<?php

namespace daos\external\reports;

class OrderDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\Order($data);
    }

    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopId($shopId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getByShopId','getByShopId',[$shopId, serialize($interval)]);
        return \models\reports\Order::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param Int $callcenter
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopIdAndCallcenter($shopId, $callcenter, \models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getByShopIdAndCallcenter','getByShopIdAndCallcenter',[$shopId, $callcenter, serialize($interval)]);
        return \models\reports\Order::undoSerialize($response);
    }

    /**
     * @param Int $callcenter
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByCallcenter($callcenter, \models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getByCallcenter','getByCallcenter',[$callcenter, serialize($interval)]);
        return \models\reports\Order::undoSerialize($response);
    }

    /**
     * @param Int $callcenter
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getNewOrdersCallcenterQuantityByShopIdAndCODState($shopId, $codState, \models\Interval $interval){
        $keyCache = "newOrdesCallcenterQuantity_{$shopId}_{$codState}_" . $interval->getInitialDate()->format('Y-m-d') . "_" . $interval->getEndDate()->format('Y-m-d');
        $cachedData = \InternalCacheManager::getInstance()->get($keyCache);
        if($cachedData != false) {
            return \models\reports\Order::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getNewCallcenterQuantityByShopIdAndCODState','getNewCallcenterQuantityByShopIdAndCODState',[$shopId, $codState, serialize($interval)]);
        \InternalCacheManager::getInstance()->set($keyCache, $response);
        return \models\reports\Order::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param string $origin
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopIdAndOrigin($shopId, $origin, \models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getByShopIdAndOrigin','getByShopIdAndOrigin',[$shopId, $origin, serialize($interval)]);
        return \models\reports\Order::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param string $status
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopIdAndStatus($shopId, $status, \models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getByShopIdAndStatus','getByShopIdAndStatus',[$shopId, $status, serialize($interval)]);
        return \models\reports\Order::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param string $status
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getDistinctOrderReportByShopIdAndStatus($shopId, $status, \models\Interval $interval){
        $keyCache = "distinctOrderReport_{$shopId}_{$status}_" . $interval->getInitialDate()->format('Y-m-d') . "_" . $interval->getEndDate()->format('Y-m-d');
        $cachedData = \InternalCacheManager::getInstance()->get($keyCache);
        if($cachedData != false) {
            return \models\reports\Order::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getDistinctByShopIdAndStatus','getDistinctByShopIdAndStatus',[$shopId, $status, serialize($interval)]);
        \InternalCacheManager::getInstance()->set($keyCache, $response);
        return \models\reports\Order::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param string $origin
     * @param string $status
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getDistinctOrderReportByShopIdAndOriginAndStatus($shopId, $origin, $status, \models\Interval $interval){
        $keyCache = "distinctOrderReport_{$shopId}_{$origin}_{$status}_" . $interval->getInitialDate()->format('Y-m-d') . "_" . $interval->getEndDate()->format('Y-m-d');
        $cachedData = \InternalCacheManager::getInstance()->get($keyCache);
        if($cachedData != false) {
            return \models\reports\Order::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getDistinctByShopIdAndOriginAndStatus','getDistinctByShopIdAndOriginAndStatus',[$shopId, $origin, $status, serialize($interval)]);
        \InternalCacheManager::getInstance()->set($keyCache, $response);
        return \models\reports\Order::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param Int $origin
     * @param string $status
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopIdAndOriginAndStatus($shopId, $origin, $status, \models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getByShopIdAndOriginAndStatus','getByShopIdAndOriginAndStatus',[$shopId, $origin, $status, serialize($interval)]);
        return \models\reports\Order::undoSerialize($response);
    }

    /**
     * @param string $orderId
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByOrderId($orderId,\models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getByOrderId','getByOrderId',[$orderId, serialize($interval)]);
        return \models\reports\Order::undoSerialize($response);
    }

}
