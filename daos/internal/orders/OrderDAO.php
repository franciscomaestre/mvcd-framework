<?php

namespace daos\internal\orders;

class OrderDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\Order($data);
    }

    public static function getOrderByDateCompletion(\models\Interval $interval = null, $validated = false){
        $whereValidated = ($validated) ? "canceled = 0 AND attend = 1 AND paid = 1" : "";
        $whereDate = (!is_null($interval)) ?
            sprintf("dateCompletion > '%s' AND dateCompletion < DATE_ADD('%s', INTERVAL 1 DAY)",
                $interval->getInitialDate()->format('Y-m-d'),
                $interval->getEndDate()->format('Y-m-d'))
            : "";

        $sql = "SELECT id FROM grupeoOrders.order";

        if ($validated){
            $sql .= " WHERE $whereValidated";
            if (!is_null($interval)){
                $sql .= " AND $whereDate";
            }
        }else{
            if (!is_null($interval)){
                $sql .= " WHERE $whereDate";
            }
        }

        try {
            $orderList = static::getOrderByQuery($sql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderList;
    }

    public static function getOrderByDateAttention(\models\Interval $interval = null, $validated = false){
        $whereValidated = ($validated) ? "canceled = 0 AND attend = 1 AND paid = 1" : "";
        $whereDate = (!is_null($interval)) ?
            sprintf("dateAttention > '%s' AND dateAttention < DATE_ADD('%s', INTERVAL 1 DAY)",
                $interval->getInitialDate()->format('Y-m-d'),
                $interval->getEndDate()->format('Y-m-d'))
            : "";

        $sql = "SELECT id FROM grupeoOrders.order";

        if ($validated){
            $sql .= " WHERE $whereValidated";
            if (!is_null($interval)){
                $sql .= " AND $whereDate";
            }
        }else{
            if (!is_null($interval)){
                $sql .= " WHERE $whereDate";
            }
        }

        try {
            $orderList = static::getOrderByQuery($sql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderList;
    }

    public static function getOrderByDateUpdate(\models\Interval $interval = null, $validated = false){
        $whereValidated = ($validated) ? "canceled = 0 AND attend = 1 AND paid = 1" : "";
        $whereDate = (!is_null($interval)) ?
            sprintf("dateUpdate > '%s' AND dateUpdate < DATE_ADD('%s', INTERVAL 1 DAY)",
                $interval->getInitialDate()->format('Y-m-d'),
                $interval->getEndDate()->format('Y-m-d'))
            : "";

        $sql = "SELECT id FROM grupeoOrders.order";

        if ($validated){
            $sql .= " WHERE $whereValidated";
            if (!is_null($interval)){
                $sql .= " AND $whereDate";
            }
        }else{
            if (!is_null($interval)){
                $sql .= " WHERE $whereDate";
            }
        }

        try {
            $orderList = static::getOrderByQuery($sql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderList;
    }

    public static function getOrderByCallcenter($callcenter, \models\Interval $interval = null, $validated = false){
        $whereValidated = ($validated) ? "AND canceled = 0 AND attend = 1 AND paid = 1" : "";
        $whereDate = (!is_null($interval)) ?
            sprintf("AND dateCompletion > '%s' AND dateCompletion < DATE_ADD('%s', INTERVAL 1 DAY)",
                $interval->getInitialDate()->format('Y-m-d'),
                $interval->getEndDate()->format('Y-m-d'))
            : "";

        $sql = "SELECT id FROM grupeoOrders.order WHERE callcenter = '%d' {$whereValidated} {$whereDate}";

        $sprintfSql = sprintf($sql,$callcenter);

        try {
            $orderList = static::getOrderByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderList;
    }

    public static function getOrderByShopId($shopId, \models\Interval $interval = null) {
        $whereDate = (!is_null($interval)) ?
            sprintf("AND dateCompletion > '%s' AND dateCompletion < DATE_ADD('%s', INTERVAL 1 DAY)",
                $interval->getInitialDate()->format('Y-m-d'),
                $interval->getEndDate()->format('Y-m-d'))
            : "";

        $sql = "SELECT id FROM grupeoOrders.order WHERE shopId='%d' $whereDate";

        $sprintfSql = sprintf($sql,$shopId);

        try {
            $orderList = static::getOrderByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderList;
    }

    public static function getOrderByShippingAddressId($shippingAddressId, \models\Interval $interval = null) {
        $whereDate = (!is_null($interval)) ?
            sprintf("AND dateCompletion > '%s' AND dateCompletion < DATE_ADD('%s', INTERVAL 1 DAY)",
                $interval->getInitialDate()->format('Y-m-d'),
                $interval->getEndDate()->format('Y-m-d'))
            : "";

        $sql = "SELECT id FROM grupeoOrders.order WHERE shippingAddressId='%s' $whereDate";

        $sprintfSql = sprintf($sql,$shippingAddressId);

        try {
            $orderList = static::getOrderByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderList;
    }

    public static function getOrderByBillingAddressId($billingAddressId, \models\Interval $interval = null) {
        $whereDate = (!is_null($interval)) ?
            sprintf("AND dateCompletion > '%s' AND dateCompletion < DATE_ADD('%s', INTERVAL 1 DAY)",
                $interval->getInitialDate()->format('Y-m-d'),
                $interval->getEndDate()->format('Y-m-d'))
            : "";

        $sql = "SELECT id FROM grupeoOrders.order WHERE billingAddressId='%s' $whereDate";

        $sprintfSql = sprintf($sql,$billingAddressId);

        try {
            $orderList = static::getOrderByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderList;
    }

    public static function getOrderByUserId($userId, \models\Interval $interval = null) {
        $whereDate = (!is_null($interval)) ?
            sprintf("AND dateCompletion > '%s' AND dateCompletion < DATE_ADD('%s', INTERVAL 1 DAY)",
                $interval->getInitialDate()->format('Y-m-d'),
                $interval->getEndDate()->format('Y-m-d'))
            : "";

        $sql = "SELECT id FROM grupeoOrders.order WHERE userId='%s' $whereDate";

        $sprintfSql = sprintf($sql,$userId);

        try {
            $orderList = static::getOrderByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderList;
    }

    public static function getOrderByImported($imported){
        $sql = "SELECT grupeoOrders.order.id"
                . " FROM grupeoOrders.order"
                . " JOIN grupeoOrders.payment ON grupeoOrders.payment.orderId = grupeoOrders.order.id"
                . " WHERE grupeoOrders.order.imported = '%d'";

        $sprintfSql = sprintf($sql,$imported);

        try {
            $orderList = static::getOrderByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderList;
    }

    public static function setOrderByImported($oldImported, $newImported, $limit = null){
        $limit = (!is_null($limit)) ? " LIMIT $limit" : '';

        $sql = "UPDATE grupeoOrders.order"
            . " SET grupeoOrders.order.imported = '%d'"
            . " WHERE grupeoOrders.order.imported = '%d'"
            . $limit;

        $sprintfSql = sprintf($sql,$newImported, $oldImported);

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param string $query
     * @return \models\orders\Order
     * @throws \Exception
     */
    private static function getOrderByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataOrderLines = self::fetchAll($queryResource);

            $orderLines = static::generateOrderLines($dataOrderLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $order = static::create();

        $order->setLines($orderLines);

        return $order;
    }

    /**
     * @param Array $dataOrderLines
     * @return \models\orders\OrderLine[]
     * @throws \Exception
     */
    private static function generateOrderLines($dataOrderLines){
        $orderLines = array();

        try {
            foreach ($dataOrderLines as $dataOrder){
                $orderLines[] = OrderLineDAO::getOrderLineById($dataOrder['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $orderLines;
    }

}
