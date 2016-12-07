<?php

namespace daos\external\bigBrother;

class TopProductDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\bigBrother\TopProduct($data);
    }

    /**
     * @param int $topNumber
     * @return \models\bigBrother\TopProduct
     */
    public static function getTopProductByShopIdAndTopNumberAndCodState($shopId, $topNumber, $codState, \models\Interval $interval){
        $cacheKey = "topProduct_{$shopId}_{$topNumber}_{$codState}_" .
            $interval->getInitialDate()->format('Y-m-d') . "_" . $interval->getEndDate()->format('Y-m-d');
        $cachedData = \InternalCacheManager::getInstance()->get($cacheKey);
        if($cachedData != false) {
            return \models\bigBrother\TopProduct::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_BIGBROTHER.'/topProduct/getByShopIdAndTopNumberAndCodState','getByShopIdAndTopNumberAndCodState',[$shopId, $topNumber, $codState, serialize($interval)]);
        \InternalCacheManager::getInstance()->set($cacheKey, $response);
        return \models\bigBrother\TopProduct::undoSerialize($response);
    }

}
