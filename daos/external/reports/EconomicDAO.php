<?php

namespace daos\external\reports;

class EconomicDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\Economic($data);
    }

    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\reports\Economic
     */
    public static function getEconomicReportByShopId($shopId, \models\Interval $interval){
        $keyCache = "economicReport_{$shopId}_" . $interval->getInitialDate()->format('Y-m-d') . "_" . $interval->getEndDate()->format('Y-m-d');
        $cachedData = \InternalCacheManager::getInstance()->get($keyCache);
        if($cachedData != false) {
            return \models\reports\Economic::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_REPORTS.'/economicReport/getByShopId','getByShopId',[$shopId, serialize($interval)]);
        \InternalCacheManager::getInstance()->set($keyCache, $response);
        return \models\reports\Economic::undoSerialize($response);
    }

    /**
     * @param string $concept
     * @param \models\Interval $interval
     * @return \models\reports\Economic
     */
    public static function getEconomicReportByConcept($concept,\models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/economicReport/getByConcept','getByConcept',[$concept, serialize($interval)]);
        return \models\reports\Economic::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param string $concept
     * @param \models\Interval $interval
     * @return \models\reports\Economic
     */
    public static function getEconomicReportByShopIdAndConcept($shopId,$concept,\models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/economicReport/getByShopIdAndConcept','getByShopIdAndConcept',[$shopId, $concept, serialize($interval)]);
        return \models\reports\Economic::undoSerialize($response);
    }

    /**
     * @param Int $orderId
     * @param \models\Interval $interval
     * @return \models\reports\Economic
     */
    public static function getEconomicReportByOrderId($orderId,\models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/economicReport/getByOrderId','getByOrderId',[$orderId, serialize($interval)]);
        return \models\reports\Economic::undoSerialize($response);
    }

}
