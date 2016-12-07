<?php

namespace daos\internal\reports;

class ProductLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\ProductLine($data);
    }

    /**
     * @param String $productReportLineId
     * @return \models\reports\ProductLine ProductReportLine
     * @throws \Exception
     */
    public static function getProductReportLineById($productReportLineId) {

        $sql = "SELECT * FROM grupeoReports.productReport WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $productReportLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataProductReportLine = self::fetch($queryResource);

        return self::create($dataProductReportLine);

    }

    /**
     * @param String $productReportLineId
     * @return \models\reports\ProductLine ProductReportLine
     * @throws \Exception
     */
    public static function getProductReportLineByOrderIdAndProductId($orderId, $productId) {

        $sql = "SELECT * FROM grupeoReports.productReport WHERE orderId = '%s' AND productId = '%d' LIMIT 1";

        $sprintfSql = sprintf($sql, $orderId, $productId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataProductReportLine = self::fetch($queryResource);

        return self::create($dataProductReportLine);

    }

    /**
     * @param \models\reports\ProductLine $productReportLine
     * @return Int $lastInsertedId
     */
    public static function insertProductReportLine($productReportLine) {

        $sql = "INSERT INTO grupeoReports.productReport (id,shopId,name,costPrice,salePrice,quantity,productId,shippingCost,orderId,merchantId,`date`,VAT,savingBook,callcenter)"
                . " VALUES ('%s','%d','%s','%.0f','%.0f','%d','%d','%.0f','%s','%d','%s','%d','%d','%d')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $productReportLine->getShopId(),
            $productReportLine->getName(),
            $productReportLine->getCostPrice()->getValueInCents(),
            $productReportLine->getSalePrice()->getValueInCents(),
            $productReportLine->getQuantity(),
            $productReportLine->getProductId(),
            $productReportLine->getShippingCost()->getValueInCents(),
            $productReportLine->getOrderId(),
            $productReportLine->getMerchantId(),
            $productReportLine->getDate()->format('Y-m-d H:i:s'),
            $productReportLine->getVAT(),
            $productReportLine->getSavingBook(),
            $productReportLine->getCallcenter());

        try {
            $lastInsertedId = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastInsertedId;

    }

    /**
     * @param \models\reports\ProductLine $productReportLine
     * @return bool $isUpdated
     * @throws \Exception
     */
    public static function updateProductReportLine($productReportLine) {

        $sql = "UPDATE grupeoReports.productReport"
                . " SET shopId = '%d', name = '%s', costPrice = '%.0f', salePrice = '%.0f', quantity = '%d', productId = '%d',"
                . " shippingCost = '%.0f', orderId = '%s', merchantId = '%d', date = '%s', VAT = '%d', savingBook = '%d', callcenter = '%d'"
                . " WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $productReportLine->getShopId(),
            $productReportLine->getName(),
            $productReportLine->getCostPrice()->getValueInCents(),
            $productReportLine->getSalePrice()->getValueInCents(),
            $productReportLine->getQuantity(),
            $productReportLine->getProductId(),
            $productReportLine->getShippingCost()->getValueInCents(),
            $productReportLine->getOrderId(),
            $productReportLine->getMerchantId(),
            $productReportLine->getDate()->format('Y-m-d H:i:s'),
            $productReportLine->getVAT(),
            $productReportLine->getSavingBook(),
            $productReportLine->getCallcenter(),
            $productReportLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;

    }

    /**
     * @param Int $productReportLineId
     * @return bool $isDeleted
     * @throws \Exception
     */
    public static function deleteProductReportLineById($productReportLineId) {

        $sql = "DELETE FROM grupeoReports.productReport WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $productReportLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;

    }

}
