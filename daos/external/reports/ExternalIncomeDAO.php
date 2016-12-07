<?php

namespace daos\external\reports;

class ExternalIncomeDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\ExternalIncome($data);
    }

    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     */
    public static function getExternalIncomeByShopId($shopId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/externalIncome/getByShopId','getByShopId',[$shopId, serialize($interval)]);
        return \models\reports\ExternalIncome::undoSerialize($response);
    }

    /**
     * @param string $concept
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     */
    public static function getExternalIncomeByConcept($concept,\models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/externalIncome/getByConcept','getByConcept',[$concept, serialize($interval)]);
        return \models\reports\ExternalIncome::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param string $concept
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     */
    public static function getExternalIncomeByShopIdAndConcept($shopId,$concept,\models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/externalIncome/getByShopIdAndConcept','getByShopIdAndConcept',[$shopId, $concept, serialize($interval)]);
        return \models\reports\ExternalIncome::undoSerialize($response);
    }

    /**
     * @param string $concept
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     */
    public static function getExternalIncomeByOrigin($concept,\models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/externalIncome/getByOrigin','getByOrigin',[$concept, serialize($interval)]);
        return \models\reports\ExternalIncome::undoSerialize($response);
    }

    /**
     * @param Int $orderId
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     */
    public static function getExternalIncomeByOrderId($orderId,\models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/externalIncome/getByOrderId','getByOrderId',[$orderId, serialize($interval)]);
        return \models\reports\ExternalIncome::undoSerialize($response);
    }

}
