<?php

namespace daos\internal\bigBrother;

class SalesPerProductLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\SalesPerProductLine($data);
    }

    /**
     * @param String $salesPerProductLineId
     * @return \models\bigBrother\SalesPerProductLine
     */
    public static function getSalesPerProductLineById($salesPerProductLineId) {
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerProduct/getLineById','getLineById',[$salesPerProductLineId]);
        return \models\bigBrother\SalesPerProductLine::undoSerialize($response);
    }

    /**
     * @param \models\bigBrother\SalesPerProductLine $salesPerProductLine
     * @return String
     */
    public static function insertSalesPerProductLine(\models\bigBrother\SalesPerProductLine $salesPerProductLine) {
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerProduct/insertLine','insertLine',[serialize($salesPerProductLine)]);
        return \models\bigBrother\SalesPerProductLine::undoSerialize($response);
    }

    /**
     * @param \models\bigBrother\SalesPerProductLine $salesPerProductLine
     * @return bool
     */
    public static function updateSalesPerProductLine(\models\bigBrother\SalesPerProductLine $salesPerProductLine) {
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerProduct/updateLine','updateLine',[serialize($salesPerProductLine)]);
        return \models\bigBrother\SalesPerProductLine::undoSerialize($response);
    }

    /**
     * @param String $salesPerProductLineId
     * @return bool
     */
    public static function deleteSalesPerProductLineById($salesPerProductLineId) {
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerProduct/deleteLineById','deleteLineById',[$salesPerProductLineId]);
        return \models\bigBrother\SalesPerProductLine::undoSerialize($response);
    }
}
