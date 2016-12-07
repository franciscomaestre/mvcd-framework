<?php

namespace daos\external\reports;

class ProductLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\ProductLine($data);
    }

    /**
     * @param String $productReportLineId
     * @return \models\reports\ProductLine ProductReportLine
     */
    public static function getProductReportLineById($productReportLineId) {
        $response = self::execute(URL_SERVER_REPORTS.'/productReport/getLineById','getLineById',[$productReportLineId]);
        return \models\reports\ProductLine::undoSerialize($response);
    }

    /**
     * @param \models\reports\ProductLine $productReportLine
     * @return Int $lastInsertedId
     */
    public static function insertProductReportLine($productReportLine) {
        $response = self::execute(URL_SERVER_REPORTS.'/productReport/insertLine','insertLine',[serialize($productReportLine)]);
        return unserialize($response);
    }

    /**
     * @param \models\reports\ProductLine $productReportLine
     * @return bool $isUpdated
     */
    public static function updateProductReportLine($productReportLine) {
        $response = self::execute(URL_SERVER_REPORTS.'/productReport/updateLine','updateLine',[serialize($productReportLine)]);
        return unserialize($response);
    }

    /**
     * @param Int $productReportLineId
     * @return bool $isDeleted
     */
    public static function deleteProductReportLineById($productReportLineId) {
        $response = self::execute(URL_SERVER_REPORTS.'/productReport/deleteLineById','deleteLineById',[$productReportLineId]);
        return unserialize($response);
    }

}
