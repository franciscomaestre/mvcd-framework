<?php

namespace daos\internal\reports;

class OrderDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\Order($data);
    }

    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopId($shopId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.orderReport WHERE shopId='%d' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $orderReport = static::getOrderReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReport;
    }

    /**
     * @param Int $shopId
     * @param Int $callcenter
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopIdAndCallcenter($shopId, $callcenter, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.orderReport WHERE shopId='%d' AND callcenter='%d' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $callcenter,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $orderReport=static::getOrderReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReport;
    }

    /**
     * @param Int $callcenter
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByCallcenter($callcenter, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.orderReport WHERE callcenter='%d' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $callcenter,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $orderReport=static::getOrderReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReport;
    }

    /**
     * @param Int $callcenter
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getNewOrdersCallcenterQuantityByShopIdAndCODState($shopId, $codState, \models\Interval $interval){

        $codStatus = ($codState == 0) ? 'pending' : 'approved';

        $sql = "SELECT count(distinct userId) AS 'new_callcenter'"
                . " FROM grupeoReports.orderReport"
                . " WHERE date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY) AND callcenter = 1 AND shopId = '%d'"
                . " AND status = 'approved' OR (origin = 'COD' AND status = '%s') AND userId NOT IN (SELECT distinct userId"
                . "  FROM grupeoReports.orderReport"
                . "  WHERE date < '%s' AND callcenter = 1 AND shopId = '%s' AND status = 'approved' OR (origin = 'COD' AND status = '%s'))";

        $sprintfSql = sprintf($sql,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            $shopId,
            $codStatus,
            $interval->getInitialDate()->format('Y-m-d'),
            $shopId,
            $codStatus);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            Throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return intval($data['new_callcenter']);
    }


    /**
     * @param Int $shopId
     * @param string $origin
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopIdAndOrigin($shopId, $origin, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.orderReport WHERE shopId='%d' AND origin='%s' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $origin,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $orderReport = static::getOrderReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReport;
    }

    /**
     * @param Int $shopId
     * @param string $origin
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopIdAndStatus($shopId, $status, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.orderReport WHERE shopId='%d' AND status='%s' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $status,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $orderReport = static::getOrderReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReport;
    }

    /**
     * @param Int $shopId
     * @param string $origin
     * @param string $status
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getDistinctOrderReportByShopIdAndStatus($shopId, $status, \models\Interval $interval){
        //$sql = "SELECT id FROM grupeoReports.orderReport WHERE shopId='%d' AND origin='%s' AND status = '%s' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        /*$sql = "SELECT *"
                . " FROM ("
                . "  SELECT gR1.*"
                . "   FROM grupeoReports.orderReport AS gR1 "
                . "   JOIN grupeoReports.transactionReport AS tr ON gR1.orderId = tr.orderId AND tr.status != 'canceled'"
                . "   WHERE gR1.shopId='%d' AND gR1.status = '%s' AND gR1.date >= '%s' AND gR1.date < DATE_ADD('%s', INTERVAL 1 DAY)"
                . "   ORDER BY gR1.`date` DESC, gR1.updatedDate DESC"
                . " ) as orderReports"
                . " group by orderId"
                . " order by `date`";*/

        $sql = "SELECT orderReports.* "
                . "FROM ( SELECT gR1.* "
                .         "FROM grupeoReports.orderReport AS gR1 "
                .         "JOIN grupeoReports.transactionReport AS tr ON gR1.orderId = tr.orderId AND tr.status != 'canceled' "
                .         "WHERE gR1.shopId='%d' AND gR1.status = '%s' AND gR1.date >= '%s' AND gR1.date < DATE_ADD('%s', INTERVAL 1 DAY) AND gR1.shippingCharges >= 0 "
                .         "ORDER BY gR1.`date` DESC, gR1.updatedDate DESC ) as orderReports "
                . "INNER JOIN ( SELECT gR1.orderId as orderId, max(updatedDate) as updatedDate "
                .         "FROM grupeoReports.orderReport AS gR1 "
                .         "JOIN grupeoReports.transactionReport AS tr ON gR1.orderId = tr.orderId AND tr.status != 'canceled' "
                .         "WHERE gR1.shopId='%d' AND gR1.status = '%s' AND gR1.date >= '%s' AND gR1.date < DATE_ADD('%s', INTERVAL 1 DAY) AND gR1.shippingCharges >= 0 "
                .         "group by gR1.orderId) as updatedDates ON orderReports.orderId = updatedDates.orderId AND orderReports.updatedDate = updatedDates.updatedDate "
                . "group by orderReports.orderId order by `date` ";

        $sprintfSql = sprintf($sql,
            $shopId,
            $status,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            $shopId,
            $status,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $orderReport = static::getOrderReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReport;
    }

    /**
     * @param Int $shopId
     * @param string $origin
     * @param string $status
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getDistinctOrderReportByShopIdAndOriginAndStatus($shopId, $origin, $status, \models\Interval $interval){
        //$sql = "SELECT id FROM grupeoReports.orderReport WHERE shopId='%d' AND origin='%s' AND status = '%s' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        /*$sql = "SELECT *"
                . " FROM ("
                . "  SELECT gR1.*"
                . "   FROM grupeoReports.orderReport AS gR1 "
                . "   JOIN grupeoReports.transactionReport AS tr ON gR1.orderId = tr.orderId AND tr.status != 'canceled'"
                . "   WHERE gR1.shopId='%d' AND gR1.origin = '%s' AND gR1.status = '%s' AND gR1.date > '%s' AND gR1.date < DATE_ADD('%s', INTERVAL 1 DAY)"
                . "   ORDER BY gR1.`date` DESC, gR1.updatedDate DESC"
                . " ) as orderReports"
                . " group by orderId"
                . " order by `date`";*/

        $sql = "SELECT orderReports.* "
            . "FROM ( SELECT gR1.* "
            .         "FROM grupeoReports.orderReport AS gR1 "
            .         "JOIN grupeoReports.transactionReport AS tr ON gR1.orderId = tr.orderId AND tr.status != 'canceled' "
            .         "WHERE gR1.shopId='%d' AND gR1.origin = '%s' AND gR1.status = '%s' AND gR1.date >= '%s' AND gR1.date < DATE_ADD('%s', INTERVAL 1 DAY) AND gR1.shippingCharges >= 0 "
            .         "ORDER BY gR1.`date` DESC, gR1.updatedDate DESC ) as orderReports "
            . "INNER JOIN ( SELECT gR1.orderId as orderId, max(updatedDate) as updatedDate "
            .         "FROM grupeoReports.orderReport AS gR1 "
            .         "JOIN grupeoReports.transactionReport AS tr ON gR1.orderId = tr.orderId AND tr.status != 'canceled' "
            .         "WHERE gR1.shopId='%d' AND gR1.origin = '%s' AND gR1.status = '%s' AND gR1.date >= '%s' AND gR1.date < DATE_ADD('%s', INTERVAL 1 DAY) AND gR1.shippingCharges >= 0 "
            .         "group by gR1.orderId) as updatedDates ON orderReports.orderId = updatedDates.orderId AND orderReports.updatedDate = updatedDates.updatedDate "
            . "group by orderReports.orderId order by `date`";

        $sprintfSql = sprintf($sql,
            $shopId,
            $origin,
            $status,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            $shopId,
            $origin,
            $status,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $orderReport = static::getOrderReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReport;
    }

    /**
     * @param Int $shopId
     * @param string $origin
     * @param string $status
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByShopIdAndOriginAndStatus($shopId, $origin, $status, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.orderReport WHERE shopId='%d' AND origin='%s' AND status = '%s' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $origin,
            $status,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $orderReport = static::getOrderReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReport;
    }

    /**
     * @param string $orderId
     * @param \models\Interval $interval
     * @return \models\reports\Order
     * @throws \Exception
     */
    public static function getOrderReportByOrderId($orderId,\models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.orderReport WHERE orderId='%s' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $orderId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $orderReport = static::getOrderReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReport;
    }

    /**
     * @param string $query
     * @return \models\reports\Order
     * @throws \Exception
     */
    private static function getOrderReportByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataOrderReportLines = self::fetchAll($queryResource);

            $orderReportLines = static::generateOrderReportLines($dataOrderReportLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $orderReport = static::create();

        $orderReport->setLines($orderReportLines);

        return $orderReport;
    }

    /**
     * @param array $dataOrderReportLines
     * @return \models\reports\OrderLine[]
     * @throws \Exception
     */
    private static function generateOrderReportLines($dataOrderReportLines){
        $orderReportlines = array();

        try {
            foreach ($dataOrderReportLines as $dataOrderReportLine) {
                $orderReportlines[] = OrderLineDAO::getOrderReportLineById($dataOrderReportLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderReportlines;
    }
}
