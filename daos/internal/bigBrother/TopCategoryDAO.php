<?php

namespace daos\internal\bigBrother;

class TopCategoryDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\TopCategory($data);
    }

    /**
     * @param int $shopId
     * @param int $topNumber
     * @param int $codState
     * @return \models\bigBrother\TopCategory
     * @throws \Exception
     */
    public static function getTopCategoryByShopIdAndTopNumberAndCodState($shopId, $topNumber, $codState, \models\Interval $interval) {

        $codSql = ($codState == '0') ? 'quantity+codNotPayedQuantity' : 'quantity';
        $sql = "SELECT id AS categoryId, shopId, categoryName, SUM(%s) AS quantity FROM grupeoBigBrother.salesPerCategory"
            . " WHERE shopId ='%d'"
            . " AND date >= '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)"
            . " GROUP BY categoryId"
            . " ORDER BY SUM(%s) DESC LIMIT %d";

        $sprintfSql = sprintf($sql,
            $codSql,
            $shopId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            $codSql,
            $topNumber);

        try {
            $topCategory = static::getTopCategoryByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $topCategory;
    }

    /**
     * @param string $query
     * @return \models\bigBrother\TopCategory
     * @throws \Exception
     */
    private static function getTopCategoryByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataTopCategoryLines = self::fetchAll($queryResource);

            $topCategoryLines = static::generateTopCategoryLines($dataTopCategoryLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        $topCategory = static::create();

        $topCategory->setLines($topCategoryLines);

        return $topCategory;
    }

    /**
     * @param Array $dataTopCategoryLines
     * @return \models\bigBrother\TopCategoryLine[]
     * @throws \Exception
     */
    private static function generateTopCategoryLines($dataTopCategoryLines){
        $topCategoryLines = array();

        try {
            foreach ($dataTopCategoryLines as $dataTopCategoryLine){
                $topCategoryLines[] = TopCategoryLineDAO::getTopCategoryLine($dataTopCategoryLine);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $topCategoryLines;
    }
}
