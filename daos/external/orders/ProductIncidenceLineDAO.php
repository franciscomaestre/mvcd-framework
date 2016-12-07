<?php

namespace daos\internal\orders;

class ProductIncidenceLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\ProductIncidenceLine($data);
    }

    /**
     * @param Int $productIncidenceId
     * @return \models\orders\ProductIncidenceLine
     * @throws \Exception
     */
    public static function getProductIncidenceLineById($productIncidenceId) {
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getLineById','getLineById',[$productIncidenceId]);
        return \models\orders\ProductIncidenceLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\ProductIncidenceLine $productIncidenceLine
     * @return int
     * @throws \Exception
     */
    public static function insertProductIncidenceLine(\models\orders\ProductIncidenceLine $productIncidenceLine) {
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/insertline','insertLine',[serialize($productIncidenceLine)]);
        return \models\orders\ProductIncidenceLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\ProductIncidenceLine $productIncidenceLine
     * @return bool
     * @throws \Exception
     */
    public static function updateProductIncidenceLine(\models\orders\ProductIncidenceLine $productIncidenceLine) {
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/updateLine','updateLine',[serialize($productIncidenceLine)]);
        return \models\orders\ProductIncidenceLine::undoSerialize($response);
    }

    /**
     * @param Int $productIncidenceId
     * @return bool
     * @throws \Exception
     */
    public static function deleteProductIncidenceLineById($productIncidenceId) {
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/deleteLineById','deleteLineById',[$productIncidenceId]);
        return \models\orders\ProductIncidenceLine::undoSerialize($response);
    }

}