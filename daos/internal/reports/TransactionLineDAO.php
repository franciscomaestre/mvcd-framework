<?php

namespace daos\internal\reports;

class TransactionLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\TransactionLine($data);
    }

    /**
     * @param Int $transactionReportLineId
     * @return \models\reports\TransactionLine
     * @throws \Exception
     */
    public static function getTransactionReportLineByOrderId($orderId) {

        $sql = "SELECT * FROM grupeoReports.transactionReport WHERE orderId = '%s'";

        $sprintfSql = sprintf($sql, $orderId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataTransactionReportLine = self::fetch($queryResource);

        return self::create($dataTransactionReportLine);
    }

    /**
     * @param Int $transactionReportLineId
     * @return \models\reports\TransactionLine
     * @throws \Exception
     */
    public static function getTransactionReportLineById($transactionReportLineId) {

        $sql = "SELECT * FROM grupeoReports.transactionReport WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $transactionReportLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataTransactionReportLine = self::fetch($queryResource);

        return self::create($dataTransactionReportLine);

    }

    /**
     * @param \models\reports\TransactionLine $transactionReportLine
     * @return Int
     * @throws \Exception
     */
    public static function insertTransactionReportLine($transactionReportLine) {

        $sql = "INSERT INTO grupeoReports.transactionReport (id,orderReportId,origin,status,amount,orderId,operationDate,paymentDate)"
                . "VALUES ('%s','%s','%s','%s','%.0f','%s','%s','%s')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $transactionReportLine->getOrderReportId(),
            $transactionReportLine->getOrigin(),
            $transactionReportLine->getStatus(),
            $transactionReportLine->getAmount()->getValueInCents(),
            $transactionReportLine->getOrderId(),
            $transactionReportLine->getOperationDate()->format('Y-m-d H:i:s'),
            $transactionReportLine->getPaymentDate()->format('Y-m-d H:i:s'));

        try {
            $lastInsertedId = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastInsertedId;

    }

    /**
     * @param \models\reports\TransactionLine $transactionReportLine
     * @return bool
     * @throws \Exception
     */
    public static function updateTransactionReportLine($transactionReportLine) {

        $sql = "UPDATE grupeoReports.transactionReport"
                . " SET orderReportId = '%s', origin = '%s', status = '%s', amount = '%.0f', orderId = '%s',"
                . " operationDate = '%s', paymentDate = '%s'"
                . " WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $transactionReportLine->getOrderReportId(),
            $transactionReportLine->getOrigin(),
            $transactionReportLine->getStatus(),
            $transactionReportLine->getAmount()->getValueInCents(),
            $transactionReportLine->getOrderId(),
            $transactionReportLine->getOperationDate()->format('Y-m-d H:i:s'),
            $transactionReportLine->getPaymentDate()->format('Y-m-d H:i:s'),
            $transactionReportLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;

    }

    /**
     * @param Int $transactionReportLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteTransactionReportLineById($transactionReportLineId) {

        $sql = "DELETE FROM grupeoReports.transactionReport WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $transactionReportLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;

    }

}
