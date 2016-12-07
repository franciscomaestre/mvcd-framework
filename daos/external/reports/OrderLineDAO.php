<?php

namespace daos\external\reports;

class OrderLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\OrderLine($data);
    }

    /**
     * @param String $orderReportId
     * @return \models\reports\OrderLine
     */
    public static function getOrderReportLineById($orderReportId) {
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getLineById','getLineById',[$orderReportId]);
        return \models\reports\OrderLine::undoSerialize($response);
    }

    /**
     * @param int $shopId
     * @return \models\reports\OrderLine
     */
    public static function getFirstOrderReportLineByShopIdAndStatus($shopId, $status) {
        $cachedData = \InternalCacheManager::getInstance()->get("orderReportLine_{$shopId}_{$status}");
        if($cachedData != false) {
            return \models\reports\OrderLine::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/getFirstLineByShopIdAndStatus','getFirstLineByShopIdAndStatus',[$shopId, $status]);
        \InternalCacheManager::getInstance()->set("orderReportLine_{$shopId}_{$status}", $response);
        return \models\reports\OrderLine::undoSerialize($response);
    }

    /**
     * @param \models\reports\OrderLine $orderReport
     * @return String
     */
    public static function insertOrderReportLine(\models\reports\OrderLine $orderReport) {
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/insertLine','insertLine',[serialize($orderReport)]);
        return unserialize($response);
    }

    /**
     * @param \models\reports\OrderLine $orderReport
     * @return bool
     */
    public static function updateOrderReportLine(\models\reports\OrderLine $orderReport) {
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/updateLine','updateLine',[serialize($orderReport)]);
        return unserialize($response);
    }

    /**
     * @param String $orderReportId
     * @return bool
     */
    public static function deleteOrderReportLineById($orderReportId) {
        $response = self::execute(URL_SERVER_REPORTS.'/orderReport/deleteLineById','deleteLineById',[serialize($orderReportId)]);
        return unserialize($response);
    }
}
