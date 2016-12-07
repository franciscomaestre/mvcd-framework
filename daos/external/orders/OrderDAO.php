<?php

namespace daos\external\orders;

class OrderDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\Order($data);
    }

    /**
     * @param \models\Interval $interval
     * @param bool $validated
     * @return \models\orders\Order
     */
    public static function getOrderByDateCompletion(\models\Interval $interval = null, $validated = false){
        $response = self::execute(URL_SERVER_ORDERS.'/order/getByDateCompletion','getByDateCompletion',[serialize($interval), $validated]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param \models\Interval $interval
     * @param bool $validated
     * @return \models\orders\Order
     */
    public static function getOrderByDateAttention(\models\Interval $interval = null, $validated = false){
        $response = self::execute(URL_SERVER_ORDERS.'/order/getByDateAttention','getByDateAttention',[serialize($interval), $validated]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param \models\Interval $interval
     * @param bool $validated
     * @return \models\orders\Order
     */
    public static function getOrderByDateUpdate(\models\Interval $interval = null, $validated = false){
        $response = self::execute(URL_SERVER_ORDERS.'/order/getByDateUpdate','getByDateUpdate',[serialize($interval), $validated]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param bool $callcenter
     * @param \models\Interval $interval
     * @param bool $validated
     * @return \models\orders\Order
     */
    public static function getOrderByCallcenter($callcenter, \models\Interval $interval = null, $validated = false){
        $response = self::execute(URL_SERVER_ORDERS.'/order/getByCallcenter','getByCallcenter',[$callcenter, serialize($interval), $validated]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param int $shopId
     * @param \models\Interval $interval
     * @return \models\orders\Order
     */
    public static function getOrderByShopId($shopId, \models\Interval $interval = null) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/getByShopId','getByShopId',[$shopId, serialize($interval)]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param string $shippingAddressId
     * @param \models\Interval $interval
     * @return \models\orders\Order
     */
    public static function getOrderByShippingAddressId($shippingAddressId, \models\Interval $interval = null) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/getByShippingAddressId','getByShippingAddressId',[$shippingAddressId, serialize($interval)]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param string $billingAddressId
     * @param \models\Interval $interval
     * @return \models\orders\Order
     */
    public static function getOrderByBillingAddressId($billingAddressId, \models\Interval $interval = null) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/getByBillingAddressId','getByBillingAddressId',[$billingAddressId, serialize($interval)]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param string $userId
     * @param \models\Interval $interval
     * @return \models\orders\Order
     */
    public static function getOrderByUserId($userId, \models\Interval $interval = null) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/getByUserId','getByUserId',[$userId, serialize($interval)]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param bool $imported
     * @return \models\orders\Order
     */
    public static function setOrderByImported($oldImported, $newImported, $limit = null) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/setByImported','setByImported',[$oldImported, $newImported, $limit]);
        return \models\orders\Order::undoSerialize($response);
    }

    /**
     * @param bool $imported
     * @return \models\orders\Order
     */
    public static function getOrderByImported($imported) {
        $response = self::execute(URL_SERVER_ORDERS.'/order/getByImported','getByImported',[$imported]);
        return \models\orders\Order::undoSerialize($response);
    }
}
