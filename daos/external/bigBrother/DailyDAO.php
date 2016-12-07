<?php

namespace daos\external\bigBrother;

class DailyDAO extends \daos\external\bases\JsonRpcClientDAO
{
    public static function create($data = null)
    {
        return new \models\bigBrother\Daily($data);
    }
    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\bigBrother\Daily
     * @throws \Exception
     */
    public static function getDailyByShopId($shopId, \models\Interval $interval)
    {
        $cacheKey = "dailyBigBrother_" . $shopId . "_" . $interval->getInitialDate()->format('Y-m-d') . "_" . $interval->getEndDate()->format('Y-m-d');
        $cachedData = \InternalCacheManager::getInstance()->get($cacheKey);
        if ($cachedData != false) {
            return \models\bigBrother\Daily::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_BIGBROTHER . '/daily/getByShopId', 'getByShopId', [$shopId, serialize($interval)]);
        \InternalCacheManager::getInstance()->set($cacheKey, $response);
        return \models\bigBrother\Daily::undoSerialize($response);
    }

}
