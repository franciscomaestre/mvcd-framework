<?php

namespace daos\external\reports;

class ProductDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\Product($data);
    }

    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByShopId($shopId, \models\Interval $interval) {
        $response = self::execute(URL_SERVER_REPORTS.'/productReport/getByShopId','getByShopId',[$shopId, serialize($interval)]);
        return \models\reports\Product::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param Int $merchantId
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByShopIdAndMerchantId($shopId, $merchantId, \models\Interval $interval) {
        $response = self::execute(URL_SERVER_REPORTS.'/productReport/getByShopIdAndMerchantId','getByShopIdAndMerchantId',[$shopId, $merchantId, serialize($interval)]);
        return \models\reports\Product::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param Int $savingBook
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByShopIdAndSavingBook($shopId, $savingBook, \models\Interval $interval) {
        $response = self::execute(URL_SERVER_REPORTS.'/productReport/getByShopIdAndSavingBook','getByShopIdAndSavingBook',[$shopId, $savingBook, serialize($interval)]);
        return \models\reports\Product::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param Int $callcenter
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByShopIdAndCallcenter($shopId, $callcenter, \models\Interval $interval) {
        $response = self::execute(URL_SERVER_REPORTS.'/productReport/getByShopIdAndCallcenter','getByShopIdAndCallcenter',[$shopId, $callcenter, serialize($interval)]);
        return \models\reports\Product::undoSerialize($response);
    }

    /**
     * @param Int $orderId
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByOrderId($orderId, \models\Interval $interval) {
        $keyCache = "productReport_{$orderId}_" . $interval->getInitialDate()->format('Y-m-d') . "_" . $interval->getEndDate()->format('Y-m-d');
        $cachedData = \InternalCacheManager::getInstance()->get($keyCache);
        if($cachedData != false) {
            return \models\reports\Product::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_REPORTS.'/productReport/getByOrderId','getByOrderId',[$orderId, serialize($interval)]);
        \InternalCacheManager::getInstance()->set($keyCache, $response);
        return \models\reports\Product::undoSerialize($response);
    }

}
