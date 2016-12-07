<?php

namespace daos\internal\bigBrother;

class MonthlyLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\MonthlyLine($data);
    }

    /**
     * @param String $monthlyLineId
     * @return \models\bigBrother\MonthlyLine
     * @throws \Exception
     */
    public static function getMonthlyLineById($monthlyLineId) {
        $sql = "SELECT * FROM grupeoBigBrother.monthlyBigBrother WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $monthlyLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\Interval $interval
     * @return \models\bigBrother\Monthly
     * @throws \Exception
     */
    public static function getMonthlyLineByShopIdAndYearAndMonth($shopId, $year, $month){

        $year = ($year < 2015) ? 2015 : $year;
        $month = ($year == 2015 && $month < 3) ? 3 : $month;

        $sql = "SELECT * FROM grupeoBigBrother.monthlyBigBrother WHERE shopId = '%d' AND YEAR(date) = '%s' AND MONTH(date) = '%s'";

        $sprintfSql = sprintf($sql,
            $shopId,
            $year,
            $month);

        _logDebug($sprintfSql);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }


    /**
     * @param \models\bigBrother\MonthlyLine $monthlyLine
     * @return String
     * @throws \Exception
     */
    public static function insertMonthlyLine(\models\bigBrother\MonthlyLine $monthlyLine) {
        $sql = "INSERT grupeoBigBrother.monthlyBigBrother (id, shopId, newUsersQuantity, userOrdersQuantity, ordersQuantity, totalAmountOrders, date)"
            . " VALUES ('%s','%d','%d','%d','%d','%.0f','%s')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $monthlyLine->getShopId(),
            $monthlyLine->getNewUsersQuantity(),
            $monthlyLine->getUserOrdersQuantity(),
            $monthlyLine->getOrdersQuantity(),
            $monthlyLine->getTotalAmountOrders()->getValueInCents(),
            $monthlyLine->getDate()->format('Y-m-d H:i:s'));

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\bigBrother\MonthlyLine $monthlyLine
     * @return bool
     * @throws \Exception
     */
    public static function updateMonthlyLine(\models\bigBrother\MonthlyLine $monthlyLine) {
        $sql = "UPDATE grupeoBigBrother.monthlyBigBrother"
            . " SET shopId = '%d', newUsersQuantity = '%d', userOrdersQuantity = '%d', ordersQuantity = '%d', totalAmountOrders = '%.0f', date = '%s' WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $monthlyLine->getShopId(),
            $monthlyLine->getNewUsersQuantity(),
            $monthlyLine->getUserOrdersQuantity(),
            $monthlyLine->getOrdersQuantity(),
            $monthlyLine->getTotalAmountOrders()->getValueInCents(),
            $monthlyLine->getDate()->format('Y-m-d H:i:s'),
            $monthlyLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $monthlyLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteMonthlyLineById($monthlyLineId) {
        $sql = "DELETE FROM grupeoBigBrother.monthlyBigBrother WHERE id='%s'";

        $sprintfSql = sprintf($sql, $monthlyLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $isDeleted;
    }
}
