<?php

namespace daos\internal\reports;

class OrderLineDAO extends \daos\internal\bases\SqlDAO {
    public static function create($data = null){
        return new \models\reports\OrderLine($data);
    }

    /**
     * @param String $orderReportLineId
     * @return \models\reports\OrderLine
     * @throws \Exception
     */
    public static function getOrderReportLineById($orderReportLineId) {
        $sql = "SELECT * FROM grupeoReports.orderReport WHERE id= '%s'";

        $sprintfSql = sprintf($sql, $orderReportLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            Throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataOrderReportLine = self::fetch($queryResource);

        return static::create($dataOrderReportLine);
    }

    /**
     * @param String $orderReportLineId
     * @return \models\reports\OrderLine
     * @throws \Exception
     */
    public static function getLastOrderReportLineByOrderId($orderId) {
        $sql = "SELECT * FROM grupeoReports.orderReport WHERE orderId = '%s' AND shippingCharges >= 0 order by `date` desc, updatedDate desc LIMIT 1";

        $sprintfSql = sprintf($sql, $orderId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            Throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataOrderReportLine = self::fetch($queryResource);

        return static::create($dataOrderReportLine);
    }

    /**
     * @param int $shopId
     * @param int $status
     * @return \models\reports\OrderLine
     * @throws \Exception
     */
    public static function getFirstOrderReportLineByShopIdAndStatus($shopId, $status) {
        $sql = "SELECT * FROM grupeoReports.orderReport WHERE shopId = '%s' AND status = '%s' AND `date` >= '2015-03-01'  ORDER BY `date` asc LIMIT 1";

        $sprintfSql = sprintf($sql, $shopId, $status);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            Throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataOrderReportLine = self::fetch($queryResource);

        return static::create($dataOrderReportLine);
    }

    /**
     * @param \models\reports\OrderLine $orderReport
     * @return String
     * @throws \Exception
     */
    public static function insertOrderReportLine(\models\reports\OrderLine $orderReport) {
        $sql = "INSERT grupeoReports.orderReport (id, shopId, userId, orderId, callcenter, date, origin, status, shippingCharges, extraCommission)"
                . " VALUES ('%s','%d','%s','%s','%d','%s','%s','%s','%.0f','%.0f')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $orderReport->getShopId(),
            $orderReport->getUserId(),
            $orderReport->getOrderId(),
            $orderReport->getCallcenter(),
            $orderReport->getDate()->format('Y-m-d H:i:s'),
            $orderReport->getOrigin(),
            $orderReport->getStatus(),
            $orderReport->getShippingCharges()->getValueInCents(),
            $orderReport->getExtraCommission()->getValueInCents());

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\reports\OrderLine $orderReport
     * @return bool
     * @throws \Exception
     */
    public static function updateOrderReportLine(\models\reports\OrderLine $orderReport) {
        $sql = "UPDATE grupeoReports.orderReport"
                . " SET shopId = '%d', userId = '%s', orderId = '%s', callcenter = '%d', date = '%s', origin = '%s', status = '%s', shippingCharges = '%.0f', extraCommission = '%.0f'"
                . " WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $orderReport->getShopId(),
            $orderReport->getUserId(),
            $orderReport->getOrderId(),
            $orderReport->getCallcenter(),
            $orderReport->getDate()->format('Y-m-d H:i:s'),
            $orderReport->getOrigin(),
            $orderReport->getStatus(),
            $orderReport->getShippingCharges()->getValueInCents(),
            $orderReport->getExtraCommission()->getValueInCents(),
            $orderReport->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $orderReportLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteOrderReportLineById($orderReportLineId) {
        $sql = "DELETE FROM grupeoReports.orderReport WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $orderReportLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;
    }
}
