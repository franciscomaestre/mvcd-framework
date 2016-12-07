<?php

namespace daos\external\bigBrother;

class MonthlyLineDAO extends \daos\external\bases\JsonRpcClientDAO
{
    public static function create($data = null)
    {
        return new \models\bigBrother\Monthly($data);
    }

    /**
     * @param Int $shopId
     * @param Int $year
     * @param Int $month
     * @return \models\bigBrother\MonthlyLine
     * @throws \Exception
     */
    public static function getMonthlyLineByShopIdAndYearAndMonth($shopId, $year, $month)
    {
        $cacheKey = "monthlyBigBrother_" . $shopId . "_" . $year . "_" . $month;
        $cachedData = \InternalCacheManager::getInstance()->get($cacheKey);
        if ($cachedData != false) {
            return \models\bigBrother\Monthly::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_BIGBROTHER . '/monthly/getLineByShopIdAndYearAndMonth', 'getLineByShopIdAndYearAndMonth', [$shopId, $year, $month]);
        \InternalCacheManager::getInstance()->set($cacheKey, $response);
        return \models\bigBrother\Monthly::undoSerialize($response);
    }

}
