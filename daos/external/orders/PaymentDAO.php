<?php

namespace daos\external\orders;

class PaymentDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\Payment($data);
    }

    /**
     * @param bool $imported
     * @return \models\orders\Payment
     * @throws \Exception
     */
    public static function getPaymentByImported($imported){
        $response = self::execute(URL_SERVER_ORDERS.'/payment/getByImported','getByImported',[$imported]);
        return \models\orders\Payment::undoSerialize($response);
    }
}