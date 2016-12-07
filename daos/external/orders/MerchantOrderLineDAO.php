<?php

namespace daos\external\orders;

class MerchantOrderLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\MerchantOrderLine($data);
    }

    /**
     * @param Int $merchantOrderId
     * @return \models\orders\MerchantOrderLine
     */
    public static function getMerchantOrderLineById($merchantOrderId) {
        $response = self::execute(URL_SERVER_ORDERS.'/merchantOrder/getLineById','getLineById',[$merchantOrderId]);
        return \models\orders\MerchantOrderLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\MerchantOrderLine $merchantOrderLine
     * @return int
     */
    public static function insertMerchantOrderLineById(\models\orders\MerchantOrderLine $merchantOrderLine) {
        $response = self::execute(URL_SERVER_ORDERS.'/merchantOrder/insertline','insertLine',[serialize($merchantOrderLine)]);
        return \models\orders\MerchantOrderLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\MerchantOrderLine $merchantOrderLine
     * @return bool
     */
    public static function updateMerchantOrderLine(\models\orders\MerchantOrderLine $merchantOrderLine) {
        $response = self::execute(URL_SERVER_ORDERS.'/merchantOrder/updateLine','updateLine',[serialize($merchantOrderLine)]);
        return \models\orders\MerchantOrderLine::undoSerialize($response);
    }

    /**
     * @param Int $merchantOrderId
     * @return bool
     */
    public static function deleteMerchantOrderLineById($merchantOrderId) {
        $response = self::execute(URL_SERVER_ORDERS.'/merchantOrder/deleteLineById','deleteLineById',[$merchantOrderId]);
        return \models\orders\MerchantOrderLine::undoSerialize($response);
    }

}
