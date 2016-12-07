<?php

namespace daos\internal\orders;

class PaymentLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\PaymentLine($data);
    }

    /**
     * @param string $payment
     * @return \models\orders\PaymentLine
     * @throws \Exception
     */
    public static function getPaymentLineById($paymentId){

        $sql = "SELECT * FROM grupeoOrders.payment WHERE id = '%s'";
        $sprintfSql = sprintf($sql, $paymentId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param string $orderId
     * @return \models\orders\PaymentLine
     * @throws \Exception
     */
    public static function getPaymentLineByOrderId($orderId){

        $sql = "SELECT * FROM grupeoOrders.payment WHERE orderId = '%s'";
        $sprintfSql = sprintf($sql, $orderId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param string $transaction
     * @return \models\orders\PaymentLine
     * @throws \Exception
     */
    public static function getPaymentLineByTransaction($transaction){

        $sql = "SELECT * FROM grupeoOrders.payment WHERE `transaction` = '%s'";
        $sprintfSql = sprintf($sql, $transaction);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\orders\PaymentLine $payment
     * @return string
     * @throws \Exception
     */
    public static function insertPaymentLine(\models\orders\PaymentLine $payment) {

        $sql = "INSERT INTO grupeoOrders.payment (id, orderId, `transaction`, origin, status, amount, currency,"
                . " errorCode, imported observationsGateway, dateCompletion)"
                . " VALUES ('%s', '%s', '%s', '%s', '%s', '%.0f', '%s', '%d', '%d', '%s', '%s')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $payment->getOrderId(),
            $payment->getTransaction(),
            $payment->getOrigin(),
            $payment->getStatus(),
            $payment->getAmount()->getValueInCents(),
            $payment->getCurrency(),
            $payment->getErrorCode(),
            $payment->getImported(),
            $payment->getObservationsGateway(),
            $payment->getDateCompletion()->format('Y-m-d H:i:s'));

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\orders\PaymentLine $payment
     * @return bool
     * @throws \Exception
     */
    public static function updatePaymentLine(\models\orders\PaymentLine $payment) {
        $sql = "UPDATE grupeoOrders.payment"
            . " SET orderId = '%s', transaction = '%s', origin = '%s', status = '%s', amount = '%.0f', currency = '%s',"
            . " errorCode = '%d', imported = '%d', observationsGateway = '%s', dateCompletion = '%s'"
            . " WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $payment->getOrderId(),
            $payment->getTransaction(),
            $payment->getOrigin(),
            $payment->getStatus(),
            $payment->getAmount()->getValueInCents(),
            $payment->getCurrency(),
            $payment->getErrorCode(),
            $payment->getImported(),
            $payment->getObservationsGateway(),
            $payment->getDateCompletion()->format('Y-m-d H:i:s'));

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $paymentId
     * @return bool
     * @throws \Exception
     */
    public static function deletePaymentLineById($paymentId) {
        $sql = "DELETE FROM grupeoOrders.payment WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $paymentId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;
    }

}
