<?php

namespace daos\internal\bigBrother;

class SalesPerCategoryDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\SalesPerCategory($data);
    }

    /**
     * @param int $id
     * @return \models\bigBrother\SalesPerCategory
     * @throws \Exception
     */
    public static function getSalesPerCategoryById($id){
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerCategory/getById','getById',[$id]);
        return \models\bigBrother\SalesPerCategory::undoSerialize($response);
    }

    /**
     * @param int $categoryId
     * @param \models\Interval $interval
     * @return \models\bigBrother\SalesPerCategory
     * @throws \Exception
     */
    public static function getSalesPerCategoryByCategoryId($categoryId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_BIGBROTHER.'/salesPerCategory/getByCategoryId','getByCategoryId',[$categoryId, serialize($interval)]);
        return \models\bigBrother\SalesPerCategory::undoSerialize($response);
    }

}