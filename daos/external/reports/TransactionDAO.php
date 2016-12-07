<?php

namespace daos\external\reports;

class TransactionDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\Transaction($data);
    }

    /**
     * @param String $origin
     * @param String $status
     * @param \models\Interval $interval
     * @return \models\reports\Transaction
     * @throws \Exception
     */
    public static function getTransactionReportByOriginAndStatus($origin, $status, \models\Interval $interval) {
        $response = self::execute(URL_SERVER_REPORTS.'/transactionReport/getByOriginAndStatus','getByOriginAndStatus',[$origin, $status, serialize($interval)]);
        return \models\reports\Transaction::undoSerialize($response);
    }

    /**
     * @param String $orderReportId
     * @param \models\Interval $interval
     * @return \models\reports\Transaction
     * @throws \Exception
     */
    public static function getTransactionReportByOrderReportId($orderReportId, \models\Interval $interval) {
        $response = self::execute(URL_SERVER_REPORTS.'/transactionReport/getByOrderReportId','getByOrderReportId',[$orderReportId, serialize($interval)]);
        return \models\reports\Transaction::undoSerialize($response);
    }

    /**
     * @param string $orderId
     * @param \models\Interval $interval
     * @return \models\reports\Transaction
     * @throws \Exception
     */
    public static function getTransactionReportByOrderId($orderId, \models\Interval $interval) {
        $response = self::execute(URL_SERVER_REPORTS.'/transactionReport/getByOrderId','getByOrderId',[$orderId, serialize($interval)]);
        return \models\reports\Transaction::undoSerialize($response);
    }

}
