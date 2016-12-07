<?php

namespace daos\external\orders;

class PaymentLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\PaymentLine($data);
    }

    /**
     * @param string $orderId
     * @return \models\orders\PaymentLine
     * @throws \Exception
     */
    public static function getPaymentLineByOrderId($orderId){
        $response = self::execute(URL_SERVER_ORDERS.'/payment/getByOrderId','getByOrderId',[$orderId]);
        return \models\orders\PaymentLine::undoSerialize($response);
    }

    /**
     * @param string $transaction
     * @return \models\orders\PaymentLine
     * @throws \Exception
     */
    public static function getPaymentLineByTransaction($transaction){
        $response = self::execute(URL_SERVER_ORDERS.'/payment/getByTransaction','getByTransaction',[$transaction]);
        return \models\orders\PaymentLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\PaymentLine $payment
     * @return string
     * @throws \Exception
     */
    public static function insertPaymentLine(\models\orders\PaymentLine $payment) {
        $response = self::execute(URL_SERVER_ORDERS.'/payment/insert','insert',[serialize($payment)]);
        return unserialize($response);
    }

    /**
     * @param \models\orders\PaymentLine $payment
     * @return bool
     * @throws \Exception
     */
    public static function updatePaymentLine(\models\orders\PaymentLine $payment) {
        $response = self::execute(URL_SERVER_ORDERS.'/payment/update','update',[serialize($payment)]);
        return unserialize($response);
    }

    /**
     * @param String $paymentId
     * @return bool
     * @throws \Exception
     */
    public static function deletePaymentLineById($paymentId) {
        $response = self::execute(URL_SERVER_ORDERS.'/payment/deleteById','deleteById',[$paymentId]);
        return unserialize($response);
    }

}
