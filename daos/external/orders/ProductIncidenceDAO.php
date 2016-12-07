<?php

namespace daos\internal\orders;

class ProductIncidenceDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\ProductIncidence($data);
    }

    /**
     * @param int $shopId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByShopId($shopId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByShopId','getByShopId',[$shopId, serialize($interval)]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

    /**
     * @param int $shopId
     * @param int $incidenceId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByShopIdAndIncidenceId($shopId, $incidenceId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByShopIdAndIncidenceId','getByShopIdAndIncidenceId',[$shopId, $incidenceId, serialize($interval)]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

    /**
     * @param int $incidenceId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByIncidenceId($incidenceId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByIncidenceId','getByIncidenceId',[$incidenceId, serialize($interval)]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

    /**
     * @param int $productId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByProductId($productId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByProductId','getByProductId',[$productId, serialize($interval)]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

    /**
     * @param int $merchantId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByMerchantId($merchantId, \models\Interval $interval){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByMerchantId','getByMerchantId',[$merchantId, serialize($interval)]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

    /**
     * @param int $shopId
     * @param \models\Interval $interval
     * @param int $solved
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByShopIdAndSolved($shopId, \models\Interval $interval, $solved){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByShopIdAndSolved','getByShopIdAndSolved',[$shopId, serialize($interval), $solved]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

    /**
     * @param int $shopId
     * @param int $incidenceId
     * @param \models\Interval $interval
     * @param int $solved
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByShopIdAndIncidenceIdAndSolved($shopId, $incidenceId, \models\Interval $interval, $solved){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByShopIdAndIncidenceIdAndSolved','getByShopIdAndIncidenceIdAndSolved',[$shopId, $incidenceId, serialize($interval), $solved]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

    /**
     * @param int $incidenceId
     * @param \models\Interval $interval
     * @param int $solved
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByIncidenceIdAndSolved($incidenceId, \models\Interval $interval, $solved){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByIncidenceIdAndSolved','getByIncidenceIdAndSolved',[$incidenceId, serialize($interval), $solved]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

    /**
     * @param int $productId
     * @param \models\Interval $interval
     * @param int $solved
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByProductIdAndSolved($productId, \models\Interval $interval, $solved){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByProductIdAndSolved','getByProductIdAndSolved',[$productId, serialize($interval), $solved]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

    /**
     * @param int $merchantId
     * @param \models\Interval $interval
     * @param int $solved
     * @return \models\orders\ProductIncidence
     */
    public static function getProductIncidenceByMerchantIdAndSolved($merchantId, \models\Interval $interval, $solved){
        $response = self::execute(URL_SERVER_ORDERS.'/productIncidence/getByMerchantIdAndSolved','getByMerchantIdAndSolved',[$merchantId, serialize($interval), $solved]);
        return \models\orders\ProductIncidence::undoSerialize($response);
    }

}