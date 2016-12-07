<?php

namespace daos\external\orders;

class OrderLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\OrderLine($data);
    }

    /**
     * @param String $orderId
     * @return \models\orders\OrderLine
     * @throws \Exception
     */
    public static function getOrderLineById($orderId) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/getLineById','getLineById',[$orderId]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param String $reference
     * @return \models\orders\OrderLine
     * @throws \Exception
     */
    public static function getOrderLineByReference($reference) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/getLineByReference','getLineByReference',[$reference]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param String $invoiceNumber
     * @return \models\orders\OrderLine
     * @throws \Exception
     */
    public static function getOrderLineByShopIdAndInvoiceNumber($shopId,$invoiceNumber) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/getLineByShopIdAndInvoiceNumber','getLineByShopIdAndInvoiceNumber',[$shopId, $invoiceNumber]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param \models\orders\OrderLine $order
     * @return String
     * @throws \Exception
     */
    public static function insertOrderLine(\models\orders\OrderLine $order) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/insertLine','insertLine',[serialize($order)]);
        return unserialize($response);
    }

    /**
     * @param \models\orders\OrderLine $order
     * @return bool
     * @throws \Exception
     */
    public static function updateOrderLine(\models\orders\OrderLine $order) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/updateLine','updateLine',[serialize($order)]);
        return unserialize($response);
    }

    /**
     * @param String $orderId
     * @return bool
     * @throws \Exception
     */
    public static function deleteOrderLineById($orderId) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/deleteLineById','deleteLineById',[$orderId]);
        return unserialize($response);
    }
}
