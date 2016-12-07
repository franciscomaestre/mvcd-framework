<?php

namespace daos\internal\bigBrother;

class DailyLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\DailyLine($data);
    }

    /**
     * @param String $dailyLineId
     * @return \models\bigBrother\DailyLine
     * @throws \Exception
     */
    public static function getDailyLineById($dailyLineId) {
        $sql = "SELECT * FROM grupeoBigBrother.dailyBigBrother WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $dailyLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\bigBrother\DailyLine $dailyLine
     * @return String
     * @throws \Exception
     */
    public static function insertDailyLine(\models\bigBrother\DailyLine $dailyLine) {
        $sql = "INSERT grupeoBigBrother.dailyBigBrother (id, shopId, newUsersQuantity, userOrdersQuantity, ordersQuantity, totalAmountOrders, date)"
            . " VALUES ('%s','%d','%d','%d','%d','%.0f','%s')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $dailyLine->getShopId(),
            $dailyLine->getNewUsersQuantity(),
            $dailyLine->getUserOrdersQuantity(),
            $dailyLine->getOrdersQuantity(),
            $dailyLine->getTotalAmountOrders()->getValueInCents(),
            $dailyLine->getDate()->format('Y-m-d H:i:s'));

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\bigBrother\DailyLine $dailyLine
     * @return bool
     * @throws \Exception
     */
    public static function updateDailyLine(\models\bigBrother\DailyLine $dailyLine) {
        $sql = "UPDATE grupeoBigBrother.dailyBigBrother"
            . " SET shopId = '%d', newUsersQuantity = '%d', userOrdersQuantity = '%d', ordersQuantity = '%d', totalAmountOrders = '%.0f', date = '%s' WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $dailyLine->getShopId(),
            $dailyLine->getNewUsersQuantity(),
            $dailyLine->getUserOrdersQuantity(),
            $dailyLine->getOrdersQuantity(),
            $dailyLine->getTotalAmountOrders()->getValueInCents(),
            $dailyLine->getDate()->format('Y-m-d H:i:s'),
            $dailyLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $dailyLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteDailyLineById($dailyLineId) {
        $sql = "DELETE FROM grupeoBigBrother.dailyBigBrother WHERE id='%s'";

        $sprintfSql = sprintf($sql, $dailyLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $isDeleted;
    }
}
