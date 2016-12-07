<?php

namespace daos\external\orders;

class ProductOrderLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\ProductOrderLine($data);
    }

    /**
     * @param String $orderLineId
     * @return \models\orders\ProductOrderLine
     */
    public static function getProductOrderLineById($orderLineId) {
        $response = self::execute(URL_SERVER_ORDERS.'/productOrder/getLineById','getLineById',[$orderLineId]);
        return \models\orders\ProductOrderLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\ProductOrderLine $productOrderLine
     * @return String
     */
    public static function insertProductOrderLineById(\models\orders\ProductOrderLine $productOrderLine) {
        $response = self::execute(URL_SERVER_ORDERS.'/productOrder/insertLineById','insertLineById',[$productOrderLine]);
        return \models\orders\ProductOrderLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\ProductOrderLine $productOrderLine
     * @return bool
     */
    public static function updateProductOrderLine(\models\orders\ProductOrderLine $productOrderLine) {
        $response = self::execute(URL_SERVER_ORDERS.'/productOrder/updateLineById','updateLineById',[serialize($productOrderLine)]);
        return \models\orders\ProductOrderLine::undoSerialize($response);
    }

    /**
     * @param String $productOrderLineId
     * @return bool
     */
    public static function deleteProductOrderLineById($productOrderLineId) {
        $response = self::execute(URL_SERVER_ORDERS.'/productOrder/deleteLineById','deleteLineById',[serialize($productOrderLineId)]);
        return \models\orders\ProductOrderLine::undoSerialize($response);
    }
}
