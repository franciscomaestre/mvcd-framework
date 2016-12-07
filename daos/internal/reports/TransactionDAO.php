<?php

namespace daos\internal\reports;

class TransactionDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\Transaction($data);
    }

    /**
     * @param $origin
     * @param $status
     * @param \models\Interval $interval
     * @return \models\reports\Transaction
     * @throws \Exception
     */
    public static function getTransactionReportByOriginAndStatus($origin, $status, \models\Interval $interval) {

        $sql = "SELECT id FROM grupeoReports.transactionReport"
            . " WHERE origin = '%s'"
            . " AND status = '%s'"
            . " AND date > '%s'"
            . " AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $origin,
            $status,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $transactionReport = static::getTransactionReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $transactionReport;
    }

    /**
     * @param $orderReportId
     * @param \models\Interval $interval
     * @return \models\reports\Transaction
     * @throws \Exception
     */
    public static function getTransactionReportByOrderReportId($orderReportId, \models\Interval $interval) {

        $sql = "SELECT id FROM grupeoReports.transactionReport"
            . " WHERE orderReportId = '%s'"
            . " AND date > '%s'"
            . " AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $orderReportId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $transactionReport = static::getTransactionReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $transactionReport;
    }

    /**
     * @param $orderId
     * @param \models\Interval $interval
     * @return \models\reports\Transaction
     * @throws \Exception
     */
    public static function getTransactionReportByOrderId($orderId, \models\Interval $interval) {

        $sql = "SELECT id FROM grupeoReports.transactionReport"
            . " WHERE orderId = '%s'"
            . " AND date > '%s'"
            . " AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $orderId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $transactionReport = static::getTransactionReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $transactionReport;
    }

    /**
     * @param $query
     * @return \models\reports\Transaction
     * @throws \Exception
     */
    private static function getTransactionReportByQuery($query) {
        try {
            $queryResource = self::select($query);

            $arrayIds = self::fetchAll($queryResource);

            $transactionReportLines = static::generateTransactionReportLines($arrayIds);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $transactionReport = self::create();

        $transactionReport->setLines($transactionReportLines);

        return $transactionReport;
    }

    /**
     * @param $arrayIds
     * @return array
     * @throws \Exception
     */
    private static function generateTransactionReportLines($arrayIds) {
        $transactionReportLines = array();

        try {
            foreach($arrayIds as $dataTransactionReport) {
                $transactionReportLines[] = TransactionLineDAO::getTransactionReportLineById($dataTransactionReport['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $transactionReportLines;

    }

}
