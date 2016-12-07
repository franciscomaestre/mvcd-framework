<?php

namespace daos\internal\bigBrother;

class SalesPerProductDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\SalesPerProduct($data);
    }

    /**
     * @param int $id
     * @return \models\bigBrother\SalesPerProduct
     * @throws \Exception
     */
    public static function getSalesPerProductById($id){
        $response = self::execute(URL_SERVER_BIGBROTHER.'/topProduct/getById','getById',[$id]);
        return \models\bigBrother\SalesPerProduct::undoSerialize($response);
    }

    /**
     * @param int $categoryId
     * @param \models\Interval $interval
     * @return \models\bigBrother\SalesPerProduct
     * @throws \Exception
     */
    public static function getSalesPerProductByProductId($categoryId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_BIGBROTHER.'/topProduct/getByProductId','getByProductId',[$categoryId, serialize($interval)]);
        return \models\bigBrother\SalesPerProduct::undoSerialize($response);
    }

}