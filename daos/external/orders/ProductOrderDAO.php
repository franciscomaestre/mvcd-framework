<?php

namespace daos\external\orders;

class ProductOrderDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\ProductOrder($data);
    }

    /**
     * @param string $orderId
     * @param bool $hiddenLines
     * @return \models\orders\ProductOrder
     * @throws \Exception
     */
    public static function getProductOrderByOrderId($orderId, $hiddenLines = false){
        $response = self::execute(URL_SERVER_ORDERS.'/productOrder/getByOrderId','getByOrderId',[$orderId, $hiddenLines]);
        return \models\orders\ProductOrder::undoSerialize($response);
    }

    /**
     * @param int $merchantId
     * @param bool $hiddenLines
     * @return \models\orders\ProductOrder
     * @throws \Exception
     */
    public static function getProductOrderByMerchantId($merchantId, $hiddenLines = false){
        $response = self::execute(URL_SERVER_ORDERS.'/productOrder/getByMerchantId','getByMerchantId',[$merchantId, $hiddenLines]);
        return \models\orders\ProductOrder::undoSerialize($response);
    }

    /**
     * @param int $merchantId
     * @param bool $shippingStatus
     * @param bool $hiddenLines
     * @return \models\orders\ProductOrder
     * @throws \Exception
     */
    public static function getProductOrderByMerchantIdAndShippingStatus($merchantId, $shippingStatus, $hiddenLines = false){
        $response = self::execute(URL_SERVER_ORDERS.'/productOrder/getByMerchantIdAndShippingStatus','getByMerchantIdAndShippingStatus',[$merchantId, $shippingStatus, $hiddenLines]);
        return \models\orders\ProductOrder::undoSerialize($response);
    }

    /**
     * @param int $merchantId
     * @param bool $savingBook
     * @param bool $hiddenLines
     * @return \models\orders\ProductOrder
     * @throws \Exception
     */
    public static function getProductOrderByMerchantIdAndSavingBook($merchantId, $savingBook, $hiddenLines = false){
        $response = self::execute(URL_SERVER_ORDERS.'/productOrder/getByMerchantIdAndSavingBook','getByMerchantIdAndSavingBook',[$merchantId, $savingBook, $hiddenLines]);
        return \models\orders\ProductOrder::undoSerialize($response);
    }

    /**
     * @param bool $imported
     * @return \models\orders\ProductOrder
     * @throws \Exception
     */
    public static function getProductOrderByImported($imported){
        $response = self::execute(URL_SERVER_REPORTS.'/productOrder/getByImported','getByImported',[$imported]);
        return \models\orders\ProductOrder::undoSerialize($response);
    }
}
