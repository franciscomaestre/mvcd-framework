<?php

namespace daos\external\reports;

class MonthlyDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\Monthly($data);
    }

    /**
     * @param Int $year
     * @param Int $month
     * @return \models\reports\Monthly
     * @throws \Exception
     */
    public static function getMonthlyReportByShopIdAndYearAndMonth($shopId, $year, $month){
        $keyCache = "monthlyReport_{$shopId}_{$year}_{$month}";
        $cachedData = \InternalCacheManager::getInstance()->get($keyCache);
        if($cachedData != false) {
            return \models\reports\Monthly::undoSerialize($cachedData);
        }
        $response = self::execute(URL_SERVER_REPORTS.'/monthlyReport/getByShopIdAndYearAndMonth','getByShopIdAndYearAndMonth',[$shopId, $year, $month]);
        \InternalCacheManager::getInstance()->set($keyCache, $response);
        return \models\reports\Monthly::undoSerialize($response);
    }

}
