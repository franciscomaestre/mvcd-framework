<?php

namespace daos\internal\bigBrother;

class SalesPerCategoryLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\SalesPerCategoryLine($data);
    }

    /**
     * @param String $salesPerCategoryLineId
     * @return \models\bigBrother\SalesPerCategoryLine
     * @throws \Exception
     */
    public static function getSalesPerCategoryLineById($salesPerCategoryLineId) {
        $sql = "SELECT * FROM grupeoBigBrother.salesPerCategory WHERE id = '%d'";

        $sprintfSql = sprintf($sql, $salesPerCategoryLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\bigBrother\SalesPerCategoryLine $salesPerCategoryLine
     * @return String
     * @throws \Exception
     */
    public static function insertSalesPerCategoryLine(\models\bigBrother\SalesPerCategoryLine $salesPerCategoryLine) {
        $sql = "INSERT grupeoBigBrother.salesPerCategory (shopId, categoryId, categoryName, quantity, codNotPayedQuantity, date)"
            . " VALUES ('%d','%d','%s','%d','%s')";

        $sprintfSql = sprintf($sql,
            $salesPerCategoryLine->getShopId(),
            $salesPerCategoryLine->getCategoryId(),
            $salesPerCategoryLine->getCategoryName(),
            $salesPerCategoryLine->getQuantity(),
            $salesPerCategoryLine->getCodNotPayedQuantity(),
            $salesPerCategoryLine->getDate()->format('Y-m-d H:i:s'));

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\bigBrother\SalesPerCategoryLine $salesPerCategoryLine
     * @return bool
     * @throws \Exception
     */
    public static function updateSalesPerCategoryLine(\models\bigBrother\SalesPerCategoryLine $salesPerCategoryLine) {
        $sql = "UPDATE grupeoBigBrother.salesPerCategory"
            . " SET shopId = '%d', categoryId = '%d', categoryName = '%s', quantity = '%d', codNotPayedQuantity = '%d', date = '%s' WHERE id = '%d'";

        $sprintfSql = sprintf($sql,
            $salesPerCategoryLine->getShopId(),
            $salesPerCategoryLine->getCategoryId(),
            $salesPerCategoryLine->getCategoryName(),
            $salesPerCategoryLine->getQuantity(),
            $salesPerCategoryLine->getCodNotPayedQuantity(),
            $salesPerCategoryLine->getDate()->format('Y-m-d H:i:s'),
            $salesPerCategoryLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $salesPerCategoryLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteSalesPerCategoryLineById($salesPerCategoryLineId) {
        $sql = "DELETE FROM grupeoBigBrother.salesPerCategory WHERE id='%s'";

        $sprintfSql = sprintf($sql, $salesPerCategoryLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $isDeleted;
    }
}
