<?php

namespace daos\external\bigBrother;

class TopCategoryDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\bigBrother\TopCategory($data);
    }

    /**
     * @param int $topNumber
     * @return \models\bigBrother\TopCategory
     */
    public static function getTopCategoryByShopIdAndTopNumberAndCodState($shopId, $topNumber, $codState, \models\Interval $interval){
        $cacheKey = "topCategory_{$shopId}_{$topNumber}_{$codState}_" .
            $interval->getInitialDate()->format('Y-m-d') . "_" . $interval->getEndDate()->format('Y-m-d');
        $cachedData = \InternalCacheManager::getInstance()->get($cacheKey);
        if($cachedData != false) {
            return \models\bigBrother\TopCategory::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_BIGBROTHER.'/topCategory/getByShopIdAndTopNumberAndCodState','getByShopIdAndTopNumberAndCodState',[$shopId, $topNumber, $codState, serialize($interval)]);
        \InternalCacheManager::getInstance()->set($cacheKey, $response);
        return \models\bigBrother\TopCategory::undoSerialize($response);
    }

}
