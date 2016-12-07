<?php

namespace daos\internal\orders;

class ProductOrderLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\ProductOrderLine($data);
    }

    /**
     * @param String $orderLineId
     * @return \models\orders\ProductOrderLine
     * @throws \Exception
     */
    public static function getProductOrderLineById($orderLineId) {
        $sql = "SELECT * FROM grupeoOrders.productOrder WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $orderLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\orders\ProductOrderLine $productOrderLine
     * @return String
     * @throws \Exception
     */
    public static function insertProductOrderLine(\models\orders\ProductOrderLine $productOrderLine) {
        $sql = "INSERT grupeoOrders.productOrder (id, orderId, productId, merchantId, merchantOrderId, merchantOrderSystemId,
                                               invoiceName, invoicePrice, invoiceCost, invoiceVAT, quantity, shippingStatus,
                                               shippingTrackingNumber, shippingAgency, freeShipping, processed, savingBook,
                                               hidden, imported, dateDelivery, dateShipping)"
            . " VALUES ('%s', '%s', '%d', '%d', '%d', '%s', '%s', '%.0f', '%.0f', '%d', '%d', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%s', '%s')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $productOrderLine->getOrderId(),
            $productOrderLine->getProductId(),
            $productOrderLine->getMerchantId(),
            $productOrderLine->getMerchantOrderId(),
            $productOrderLine->getMerchantOrderSystemId(),
            $productOrderLine->getInvoiceName(),
            $productOrderLine->getInvoicePrice(),
            $productOrderLine->getInvoiceCost(),
            $productOrderLine->getInvoiceVAT(),
            $productOrderLine->getQuantity(),
            $productOrderLine->getShippingStatus(),
            $productOrderLine->getShippingTrackingNumber(),
            $productOrderLine->getShippingAgency(),
            $productOrderLine->getFreeShipping(),
            $productOrderLine->getProcessed(),
            $productOrderLine->getSavingBook(),
            $productOrderLine->getHidden(),
            $productOrderLine->getImported(),
            $productOrderLine->getDateDelivery()->format('Y-m-d H:i:s'),
            $productOrderLine->getDateShipping()->format('Y-m-d H:i:s'));

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\orders\ProductOrderLine $productOrderLine
     * @return bool
     * @throws \Exception
     */
    public static function updateProductOrderLine(\models\orders\ProductOrderLine $productOrderLine) {
        $sql = "UPDATE grupeoOrders.productOrder"
            . " SET orderId = '%s', productId = '%d', merchantId = '%d', merchantOrderId = '%d', merchantOrderSystemId = '%s',
                    invoiceName = '%s', invoicePrice = '%.0f', invoiceCost = '%.0f', invoiceVAT = '%d', quantity = '%d',
                    shippingStatus = '%s', shippingTrackingNumber = '%s', shippingAgency = '%s', freeShipping = '%d',
                    processed = '%d', savingBook = '%d', hidden = '%d', imported = '%s', dateDelivery = '%s', dateShipping = '%s'"
            . " WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $productOrderLine->getOrderId(),
            $productOrderLine->getProductId(),
            $productOrderLine->getMerchantId(),
            $productOrderLine->getMerchantOrderId(),
            $productOrderLine->getMerchantOrderSystemId(),
            $productOrderLine->getInvoiceName(),
            $productOrderLine->getInvoicePrice(),
            $productOrderLine->getInvoiceCost(),
            $productOrderLine->getInvoiceVAT(),
            $productOrderLine->getQuantity(),
            $productOrderLine->getShippingStatus(),
            $productOrderLine->getShippingTrackingNumber(),
            $productOrderLine->getShippingAgency(),
            $productOrderLine->getFreeShipping(),
            $productOrderLine->getProcessed(),
            $productOrderLine->getSavingBook(),
            $productOrderLine->getHidden(),
            $productOrderLine->getImported(),
            $productOrderLine->getDateDelivery()->format('Y-m-d H:i:s'),
            $productOrderLine->getDateShipping()->format('Y-m-d H:i:s'),
            $productOrderLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $productOrderId
     * @return bool
     * @throws \Exception
     */
    public static function deleteProductOrderLineById($productOrderId) {
        $sql = "DELETE FROM grupeoOrders.productOrder WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $productOrderId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;
    }
}
