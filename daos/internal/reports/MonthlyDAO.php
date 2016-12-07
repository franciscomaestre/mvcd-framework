<?php

namespace daos\internal\reports;

class MonthlyDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\Monthly($data);
    }

    public static function getMonthlyReportByShopIdAndYearAndMonth($shopId, $year, $month){

        $year = ($year < 2015) ? 2015 : $year;
        $month = ($year == 2015 && $month < 3) ? 3 : $month;

        $sql = "SELECT SUM(productQuantity) AS productQuantity, SUM(productQuantitySavingBook) as productQuantitySavingBook,"
                . " SUM(orderQuantitySavingBook) AS orderQuantitySavingBook, SUM(totalCost) as totalCost, SUM(totalCostSavingBook) as totalCostSavingBook,"
                . " SUM(totalProductPrice) as totalProductPrice, SUM(totalProductPriceSavingBook) as totalProductPriceSavingBook,"
                . " SUM(orderQuantity)-SUM(orderQuantitySavingBook) AS orderQuantityOnline, SUM(totalAmount) AS totalAmount,"
                . " SUM(totalAmountSavingBook) AS totalAmountSavingBook, SUM(totalAmount)-SUM(totalAmountSavingBook) AS totalAmountOnline"
                . " FROM grupeoReports.dailyReport"
                . " WHERE shopId = '%d' AND YEAR(date) = '%s' AND MONTH(date) = '%s'";

        $sprintfSql = sprintf($sql, $shopId, $year, $month);

        try {
            $queryResource = self::select($sprintfSql);
            $dataMonthlyReports = self::fetch($queryResource);
            $monthlyReport = static::create($dataMonthlyReports);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $monthlyReport;
    }

}
