<?php

namespace daos\internal\bigBrother;

class SalesPerProductDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\SalesPerProduct($data);
    }

    /**
     * @param int $id
     * @return \models\bigBrother\SalesPerProduct
     * @throws \Exception
     */
    public static function getSalesPerProductById($id){
        $sql = "SELECT id FROM grupeoBigBrother.salesPerProduct WHERE id='%d'";

        $sprintfSql = sprintf($sql, $id);

        try {
            $salesPerProduct = static::getSalesPerProductByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $salesPerProduct;
    }

    /**
     * @param int $productId
     * @return \models\bigBrother\SalesPerProduct
     * @throws \Exception
     */
    public static function getSalesPerProductByProductId($productId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoBigBrother.salesPerProduct WHERE productId='%d' AND date >= '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY) ORDER BY quantity DESC";

        $sprintfSql = sprintf($sql,
            $productId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $salesPerProduct = static::getSalesPerProductByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $salesPerProduct;
    }

    /**
     * @param string $query
     * @return \models\bigBrother\SalesPerProduct
     * @throws \Exception
     */
    private static function getSalesPerProductByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataSalesPerProductLines = self::fetchAll($queryResource);

            $salesPerProductLines = static::generateSalesPerProductLines($dataSalesPerProductLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $salesPerProduct = static::create();

        $salesPerProduct->setLines($salesPerProductLines);

        return $salesPerProduct;
    }

    /**
     * @param Array $dataSalesPerProductLines
     * @return \models\bigBrother\SalesPerProductLine[]
     * @throws \Exception
     */
    private static function generateSalesPerProductLines($dataSalesPerProductLines){
        $salesPerProductLines = array();

        try {
            foreach ($dataSalesPerProductLines as $dataSalesPerProductLine){
                $salesPerProductLines[] = SalesPerProductLineDAO::getSalesPerProductLineById($dataSalesPerProductLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $salesPerProductLines;
    }
}
