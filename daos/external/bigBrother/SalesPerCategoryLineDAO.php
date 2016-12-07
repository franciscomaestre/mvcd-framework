<?php

namespace daos\internal\bigBrother;

class SalesPerCategoryLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\SalesPerCategoryLine($data);
    }

    /**
     * @param String $salesPerCategoryLineId
     * @return \models\bigBrother\SalesPerCategoryLine
     */
    public static function getSalesPerCategoryLineById($salesPerCategoryLineId) {
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerCategory/getLineById','getLineById',[$salesPerCategoryLineId]);
        return \models\bigBrother\SalesPerCategoryLine::undoSerialize($response);
    }

    /**
     * @param \models\bigBrother\SalesPerCategoryLine $salesPerCategoryLine
     * @return String
     */
    public static function insertSalesPerCategoryLine(\models\bigBrother\SalesPerCategoryLine $salesPerCategoryLine) {
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerCategory/insertLine','insertLine',[serialize($salesPerCategoryLine)]);
        return \models\bigBrother\SalesPerCategoryLine::undoSerialize($response);
    }

    /**
     * @param \models\bigBrother\SalesPerCategoryLine $salesPerCategoryLine
     * @return bool
     */
    public static function updateSalesPerCategoryLine(\models\bigBrother\SalesPerCategoryLine $salesPerCategoryLine) {
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerCategory/updateLine','updateLine',[serialize($salesPerCategoryLine)]);
        return \models\bigBrother\SalesPerCategoryLine::undoSerialize($response);
    }

    /**
     * @param String $salesPerCategoryLineId
     * @return bool
     */
    public static function deleteSalesPerCategoryLineById($salesPerCategoryLineId) {
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerCategory/deleteLineById','deleteLineById',[$salesPerCategoryLineId]);
        return \models\bigBrother\SalesPerCategoryLine::undoSerialize($response);
    }
}
