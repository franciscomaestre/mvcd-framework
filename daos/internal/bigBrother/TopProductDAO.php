<?php

namespace daos\internal\bigBrother;

class TopProductDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\TopProduct($data);
    }

    /**
     * @param int $shopId
     * @param int $topNumber
     * @param int $codState
     * @return \models\bigBrother\TopProduct
     * @throws \Exception
     */
    public static function getTopProductByShopIdAndTopNumberAndCodState($shopId, $topNumber, $codState, \models\Interval $interval) {

        $codQuantitySql = ($codState == '0') ? 'quantity+codNotPayedQuantity' : 'quantity';
        $codAmountSql = ($codState == '0') ? 'amount+codNotPayedAmount' : 'amount';
        $sql = "SELECT id AS productParentId, shopId, productName, image, alt, SUM(%s) as amount, SUM(%s) AS quantity FROM grupeoBigBrother.salesPerProduct"
            . " WHERE shopId ='%d'"
            . " AND date >= '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)"
            . " GROUP BY productParentId"
            . " ORDER BY SUM(%s) DESC LIMIT %d";


        $sprintfSql = sprintf($sql,
            $codAmountSql,
            $codQuantitySql,
            $shopId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            $codQuantitySql,
            $topNumber);

        try {
            $topProduct = static::getTopProductByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $topProduct;
    }

    /**
     * @param string $query
     * @return \models\bigBrother\TopProduct
     * @throws \Exception
     */
    private static function getTopProductByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataTopProductLines = self::fetchAll($queryResource);

            $topProductLines = static::generateTopProductLines($dataTopProductLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        $topProduct = static::create();

        $topProduct->setLines($topProductLines);

        return $topProduct;
    }

    /**
     * @param Array $dataTopProductLines
     * @return \models\bigBrother\TopProductLine[]
     * @throws \Exception
     */
    private static function generateTopProductLines($dataTopProductLines){
        $topProductLines = array();

        try {
            foreach ($dataTopProductLines as $dataTopProductLine){
                $topProductLines[] = TopProductLineDAO::getTopProductLine($dataTopProductLine);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $topProductLines;
    }
}
