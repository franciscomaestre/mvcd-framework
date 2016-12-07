<?php

namespace daos\external\orders;

class MerchantOrderDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\MerchantOrder($data);
    }

    /**
     * @param int $merchantId
     * @param \models\Interval $interval
     * @return \models\orders\MerchantOrder
     */
    public static function getMerchantOrderByMerchantId($merchantId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_REPORTS.'/merchantOrder/getByMerchantId','getByMerchantId',[$merchantId, serialize($interval)]);
        return \models\orders\MerchantOrder::undoSerialize($response);
    }

    /**
     * @param int $merchantId
     * @param \models\Interval $interval
     * @param bool $paid
     * @return \models\orders\MerchantOrder
     */
    public static function getMerchantOrderByMerchantIdAndPaid($merchantId, \models\Interval $interval, $paid = true){
        $response = self::execute(URL_SERVER_REPORTS.'/merchantOrder/getByMerchantIdAndPaid','getByMerchantIdAndPaid',[$merchantId, serialize($interval), $paid]);
        return \models\orders\MerchantOrder::undoSerialize($response);
    }

}