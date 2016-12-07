<?php

namespace daos\internal\reports;

class ProductDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null) {
        return new \models\reports\Product($data);
    }

    /**
     * @param $shopId
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByShopId($shopId, \models\Interval $interval) {
        $sql = "SELECT id FROM grupeoReports.productReport" . " WHERE shopId = '%d'" . " AND salePrice > 0 AND date > '%s'" . " AND date < DATE_ADD('%s', INTERVAL 1 DAY)";
        $sprintfSql = sprintf($sql, $shopId, $interval->getInitialDate()->format('Y-m-d'), $interval->getEndDate()->format('Y-m-d'));
        try {
            $productReport = static::getProductReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $productReport;
    }

    /**
     * @param $shopId
     * @param $merchantId
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByShopIdAndMerchantId($shopId, $merchantId, \models\Interval $interval) {
        $sql = "SELECT id FROM grupeoReports.productReport" . " WHERE shopId = '%d'" . " AND salePrice > 0 AND merchantId = '%d'" . " AND date > '%s'" . " AND date < DATE_ADD('%s', INTERVAL 1 DAY)";
        $sprintfSql = sprintf($sql, $shopId, $merchantId, $interval->getInitialDate()->format('Y-m-d'), $interval->getEndDate()->format('Y-m-d'));
        try {
            $productReport = static::getProductReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productReport;
    }

    /**
     * @param $shopId
     * @param $savingBook
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByShopIdAndSavingBook($shopId, $savingBook, \models\Interval $interval) {
        $sql = "SELECT id FROM grupeoReports.productReport" . " WHERE shopId = '%d'" . " AND salePrice > 0 AND savingBook = '%d'" . " AND date > '%s'" . " AND date < DATE_ADD('%s', INTERVAL 1 DAY)";
        $sprintfSql = sprintf($sql, $shopId, $savingBook, $interval->getInitialDate()->format('Y-m-d'), $interval->getEndDate()->format('Y-m-d'));
        try {
            $productReport = static::getProductReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productReport;
    }

    /**
     * @param $shopId
     * @param $callcenter
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByShopIdAndCallcenter($shopId, $callcenter, \models\Interval $interval) {
        $sql = "SELECT id FROM grupeoReports.productReport" . " WHERE shopId = '%d'" . " AND salePrice > 0 AND callcenter = '%d'" . " AND date > '%s'" . " AND date < DATE_ADD('%s', INTERVAL 1 DAY)";
        $sprintfSql = sprintf($sql, $shopId, $callcenter, $interval->getInitialDate()->format('Y-m-d'), $interval->getEndDate()->format('Y-m-d'));
        try {
            $productReport = static::getProductReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productReport;
    }

    /**
     * @param $orderId
     * @param \models\Interval $interval
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByOrderId($orderId, \models\Interval $interval) {
        $sql = "SELECT id FROM grupeoReports.productReport" . " WHERE orderId = '%s'" . " AND salePrice > 0 AND date > '%s'" . " AND date < DATE_ADD('%s', INTERVAL 1 DAY) ORDER BY `date`";
        $sprintfSql = sprintf($sql, $orderId, $interval->getInitialDate()->format('Y-m-d'), $interval->getEndDate()->format('Y-m-d'));
        try {
            $productReport = static::getProductReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productReport;
    }

    /**
     * @param $orderId
     * @return \models\reports\Product
     * @throws \Exception
     */
    public static function getProductReportByOrderIdAnytime($orderId) {
        $sql = "SELECT id FROM grupeoReports.productReport" . " WHERE orderId = '%s' AND salePrice > 0";
        $sprintfSql = sprintf($sql, $orderId);
        try {
            $productReport = static::getProductReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productReport;
    }

    /**
     * @param $query
     * @return \models\reports\Product
     * @throws \Exception
     */
    private static function getProductReportByQuery($query) {
        try {
            $queryResource = self::select($query);
            $arrayIds = self::fetchAll($queryResource);
            $productReportLines = static::generateProductReportLines($arrayIds);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        $productReport = self::create();
        $productReport->setLines($productReportLines);
        return $productReport;
    }

    /**
     * @param $arrayIds
     * @return array
     * @throws \Exception
     */
    private static function generateProductReportLines($arrayIds) {
        $productReportLines = array();
        try {
            foreach ($arrayIds as $dataProductReport) {
                $productReportLines[] = ProductLineDAO::getProductReportLineById($dataProductReport['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productReportLines;
    }
}

