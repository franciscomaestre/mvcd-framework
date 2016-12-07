<?php

namespace daos\internal\orders;

class OrderLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\OrderLine($data);
    }

    /**
     * @param String $orderId
     * @return \models\orders\OrderLine
     * @throws \Exception
     */
    public static function getOrderLineById($orderId) {
        $sql = "SELECT * FROM grupeoOrders.order WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $orderId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        $orderLine = static::create($data);

        $orderLine->setProductOrder(ProductOrderDAO::getProductOrderByOrderId($orderLine->getId()));
        $orderLine->setPaymentLine(PaymentLineDAO::getPaymentLineByOrderId($orderLine->getId()));

        return $orderLine;
    }

    /**
     * @param String $reference
     * @return \models\orders\OrderLine
     * @throws \Exception
     */
    public static function getOrderLineByReference($reference) {
        $sql = "SELECT * FROM grupeoOrders.order WHERE reference = '%s'";

        $sprintfSql = sprintf($sql, $reference);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        $orderLine = static::create($data);

        $orderLine->setProductOrder(ProductOrderDAO::getProductOrderByOrderId($orderLine->getId()));
        $orderLine->setPaymentLine(PaymentLineDAO::getPaymentLineByOrderId($orderLine->getId()));

        return $orderLine;
    }

    /**
     * @param Int $shopId
     * @param String $invoiceNumber
     * @return \models\orders\OrderLine
     * @throws \Exception
     */
    public static function getOrderLineByShopIdAndInvoiceNumber($shopId,$invoiceNumber) {
        $sql = "SELECT * FROM grupeoOrders.order WHERE shopId = '%d' AND invoiceNumber = '%d'";

        $sprintfSql = sprintf($sql, $shopId, $invoiceNumber);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        $orderLine = static::create($data);

        $orderLine->setProductOrder(ProductOrderDAO::getProductOrderByOrderId($orderLine->getId()));
        $orderLine->setPaymentLine(PaymentLineDAO::getPaymentLineByOrderId($orderLine->getId()));

        return $orderLine;
    }

    /**
     * @param \models\orders\OrderLine $order
     * @return String
     * @throws \Exception
     */
    public static function insertOrderLine(\models\orders\OrderLine $order) {
        $sql = "INSERT grupeoOrders.order (id, reference, userId, shopId, invoiceNumber, amount, shippingCharges,"
                 . " shippingCosts, discount, repayment, extraCommissions, observationsGateway,"
                 . " observationsClient, observationsAdministration, shippingAddressId, billingAddressId,"
                 . " canceled, incidence, attend, paid, callcenter, reviewSent, invoiced, imported, userAgent, userIp, dateCompletion,"
                 . " dateAttention, dateUpdate)"
                 . " VALUES ('%s', '%s', '%s', '%d', '%d', '%.0f', '%.0f', '%.0f', '%.0f', '%.0f', '%.0f', '%s',"
                 . " '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $order->getReference(),
            $order->getUserId(),
            $order->getShopId(),
            $order->getInvoiceNumber(),
            $order->getAmount(),
            $order->getShippingCharges(),
            $order->getShippingCosts(),
            $order->getDiscount(),
            $order->getRepayment(),
            $order->getExtraCommissions(),
            $order->getObservationsGateway(),
            $order->getObservationsClient(),
            $order->getObservationsAdministration(),
            $order->getShippingAddressId(),
            $order->getBillingAddressId(),
            $order->getCanceled(),
            $order->getIncidence(),
            $order->getAttend(),
            $order->getPaid(),
            $order->getCallcenter(),
            $order->getReviewSent(),
            $order->getInvoiced(),
            $order->getImported(),
            $order->getUserAgent(),
            $order->getUserIp(),
            $order->getDateCompletion()->format('Y-m-d H:i:s'),
            $order->getDateAttention()->format('Y-m-d H:i:s'),
            $order->getDateUpdate()->format('Y-m-d H:i:s'));

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\orders\OrderLine $order
     * @return bool
     * @throws \Exception
     */
    public static function updateOrderLine(\models\orders\OrderLine $order) {
        $sql = "UPDATE grupeoOrders.order"
            . " SET reference = '%s', userId = '%s', shopId = '%d', invoiceNumber = '%d', amount = '%.0f',"
            . " shippingCharges = '%.0f', shippingCosts = '%.0f', discount = '%.0f', repayment = '%.0f',"
            . " extraCommissions = '%.0f', observationsGateway = '%s', observationsClient = '%s',"
            . " observationsAdministration = '%s', shippingAddressId = '%s', billingAddressId = '%s',"
            . " canceled = '%d', incidence = '%d', attend = '%d', paid = '%d', callcenter = '%d', invoiced = '%d', reviewSent = '%d',"
            . " imported = '%d', userAgent = '%s', userIp = '%s', dateCompletion = '%s', dateAttention = '%s', dateUpdate = '%s'"
            . " WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $order->getReference(),
            $order->getUserId(),
            $order->getShopId(),
            $order->getInvoiceNumber(),
            $order->getAmount(),
            $order->getShippingCharges(),
            $order->getShippingCosts(),
            $order->getDiscount(),
            $order->getRepayment(),
            $order->getExtraCommissions(),
            $order->getObservationsGateway(),
            $order->getObservationsClient(),
            $order->getObservationsAdministration(),
            $order->getShippingAddressId(),
            $order->getBillingAddressId(),
            $order->getCanceled(),
            $order->getIncidence(),
            $order->getAttend(),
            $order->getPaid(),
            $order->getCallcenter(),
            $order->getInvoiced(),
            $order->getReviewSent(),
            $order->getImported(),
            $order->getUserAgent(),
            $order->getUserIp(),
            $order->getDateCompletion()->format('Y-m-d H:i:s'),
            $order->getDateAttention()->format('Y-m-d H:i:s'),
            $order->getDateUpdate()->format('Y-m-d H:i:s'),
            $order->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $orderId
     * @return bool
     * @throws \Exception
     */
    public static function deleteOrderLineById($orderId) {
        $sql = "DELETE FROM grupeoOrders.order WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $orderId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;
    }
}
