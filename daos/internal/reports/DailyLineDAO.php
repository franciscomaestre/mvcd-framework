<?php

namespace daos\internal\reports;

class DailyLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\DailyLine($data);
    }

    /**
     * @param String $dailyReportLineId
     * @return \models\reports\DailyLine
     * @throws \Exception
     */
    public static function getDailyReportLineById($dailyReportLineId) {
        $sql = "SELECT * FROM grupeoReports.dailyReport WHERE id= '%s'";

        $sprintfSql = sprintf($sql, $dailyReportLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataDailyReportLine = self::fetch($queryResource);

        return static::create($dataDailyReportLine);
    }

    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\reports\DailyLine
     * @throws \Exception
     */
    public static function getDailyReportLineByDate($shopId, \DateTime $date) {
        $sql = "SELECT * FROM grupeoReports.dailyReport WHERE shopId='%d' AND date like '%%%s%%' LIMIT 1";

        $sprintfSql = sprintf($sql,
            $shopId,
            $date->format('Y-m-d'));

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataDailyReportLine = self::fetch($queryResource);

        return static::create($dataDailyReportLine);
    }

    /**
     * @param \models\reports\DailyLine $dailyReport
     * @return Int
     * @throws \Exception
     */
    public static function insertDailyReportLine(\models\reports\DailyLine $dailyReportLine) {
        $sql = "INSERT grupeoReports.dailyReport (id, shopId, productQuantity, productQuantitySavingBook, orderQuantity, orderQuantitySavingBook, totalProductPrice, totalProductPriceSavingBook, totalAmount, totalAmountSavingBook, totalCost, totalCostSavingBook, date, amountVAT21, amountVAT10, amountVAT4)"
                . " VALUES ('%s','%d','%d','%d','%d','%d','%.0f', '%.0f','%.0f','%.0f','%.0f', '%.0f', '%s','%.0f','%.0f','%.0f')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $dailyReportLine->getShopId(),
            $dailyReportLine->getProductQuantity(),
            $dailyReportLine->getProductQuantitySavingBook(),
            $dailyReportLine->getOrderQuantity(),
            $dailyReportLine->getOrderQuantitySavingBook(),
            $dailyReportLine->getTotalProductPrice()->getValueInCents(),
            $dailyReportLine->getTotalProductPriceSavingBook()->getValueInCents(),
            $dailyReportLine->getTotalAmount()->getValueInCents(),
            $dailyReportLine->getTotalAmountSavingBook()->getValueInCents(),
            $dailyReportLine->getTotalCost()->getValueInCents(),
            $dailyReportLine->getTotalCostSavingBook()->getValueInCents(),
            $dailyReportLine->getDate()->format('Y-m-d'),
            $dailyReportLine->getAmountVAT21()->getValueInCents(),
            $dailyReportLine->getAmountVAT10()->getValueInCents(),
            $dailyReportLine->getAmountVAT4()->getValueInCents());

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\reports\DailyLine $dailyReportLine
     * @return bool
     * @throws \Exception
     */
    public static function updateDailyReportLine(\models\reports\DailyLine $dailyReportLine) {
        $sql = "UPDATE grupeoReports.dailyReport"
                . " SET shopId = '%d',productQuantity = '%d', productQuantitySavingBook = '%d',"
                . " orderQuantity = '%d', orderQuantitySavingBook = '%d', totalProductPrice = '%.0f', totalProductPriceSavingBook = '%.0f',"
                . " totalAmount = '%.0f', totalAmountSavingBook = '%.0f', totalCost = '%.0f', totalCostSavingBook = '%.0f', date = '%s',"
                . " amountVAT21 = '%.0f', amountVAT10 = '%.0f', amountVAT4 = '%.0f'"
                . " WHERE id = '%s'";

        $sql = sprintf($sql,
            $dailyReportLine->getShopId(),
            $dailyReportLine->getProductQuantity(),
            $dailyReportLine->getProductQuantitySavingBook(),
            $dailyReportLine->getOrderQuantity(),
            $dailyReportLine->getOrderQuantitySavingBook(),
            $dailyReportLine->getTotalProductPrice()->getValueInCents(),
            $dailyReportLine->getTotalProductPriceSavingBook()->getValueInCents(),
            $dailyReportLine->getTotalAmount()->getValueInCents(),
            $dailyReportLine->getTotalAmountSavingBook()->getValueInCents(),
            $dailyReportLine->getTotalCost()->getValueInCents(),
            $dailyReportLine->getTotalCostSavingBook()->getValueInCents(),
            $dailyReportLine->getDate()->format('Y-m-d'),
            $dailyReportLine->getAmountVAT21()->getValueInCents(),
            $dailyReportLine->getAmountVAT10()->getValueInCents(),
            $dailyReportLine->getAmountVAT4()->getValueInCents(),
            $dailyReportLine->getId());

        try {
            $isUpdated = self::update($sql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param Int $dailyReportLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteDailyReportLineById($dailyReportLineId) {
        $sql = "DELETE FROM grupeoReports.dailyReport WHERE id='%s'";
        $sprintfSql = sprintf($sql, $dailyReportLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;
    }
}
