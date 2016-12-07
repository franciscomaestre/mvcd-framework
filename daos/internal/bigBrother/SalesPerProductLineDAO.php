<?php

namespace daos\internal\bigBrother;

class SalesPerProductLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\SalesPerProductLine($data);
    }

    /**
     * @param String $salesPerProductLineId
     * @return \models\bigBrother\SalesPerProductLine
     * @throws \Exception
     */
    public static function getSalesPerProductLineById($salesPerProductLineId) {
        $sql = "SELECT * FROM grupeoBigBrother.salesPerProduct WHERE id = '%d'";

        $sprintfSql = sprintf($sql, $salesPerProductLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\bigBrother\SalesPerProductLine $salesPerProductLine
     * @return String
     * @throws \Exception
     */
    public static function insertSalesPerProductLine(\models\bigBrother\SalesPerProductLine $salesPerProductLine) {
        $sql = "INSERT grupeoBigBrother.salesPerProduct (shopId, productId, productName, quantity, codNotPayedQuantity, amount, codNotPayedAmount, image, alt, date)"
            . " VALUES ('%d','%s','%d','%.0f','%.0f','%s','%s','%s')";

        $sprintfSql = sprintf($sql,
            $salesPerProductLine->getShopId(),
            $salesPerProductLine->getProductId(),
            $salesPerProductLine->getProductName(),
            $salesPerProductLine->getQuantity(),
            $salesPerProductLine->getCodNotPayedQuantity(),
            $salesPerProductLine->getAmount(),
            $salesPerProductLine->getCodNotPayedAmount(),
            $salesPerProductLine->getImage(),
            $salesPerProductLine->getAlt(),
            $salesPerProductLine->getDate());

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\bigBrother\SalesPerProductLine $salesPerProductLine
     * @return bool
     * @throws \Exception
     */
    public static function updateSalesPerProductLine(\models\bigBrother\SalesPerProductLine $salesPerProductLine) {
        $sql = "UPDATE grupeoBigBrother.salesPerProduct"
            . " SET shopId = '%d', productId = '%d', productName = '%s', quantity = '%d', codNotPayedQuantity = '%d', amount = '%.0f', codNotPayedAmount = '%.0f', image = '%s', alt = '%s', date = '%s'"
            . " WHERE id = '%d'";

        $sprintfSql = sprintf($sql,
            $salesPerProductLine->getShopId(),
            $salesPerProductLine->getProductId(),
            $salesPerProductLine->getProductName(),
            $salesPerProductLine->getQuantity(),
            $salesPerProductLine->getCodNotPayedQuantity(),
            $salesPerProductLine->getAmount(),
            $salesPerProductLine->getCodNotPayedAmount(),
            $salesPerProductLine->getImage(),
            $salesPerProductLine->getAlt(),
            $salesPerProductLine->getDate(),
            $salesPerProductLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $salesPerProductLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteSalesPerProductLineById($salesPerProductLineId) {
        $sql = "DELETE FROM grupeoBigBrother.salesPerProduct WHERE id='%s'";

        $sprintfSql = sprintf($sql, $salesPerProductLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $isDeleted;
    }
}
