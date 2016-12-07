<?php

namespace daos\internal\bigBrother;

class SalesPerCategoryDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\SalesPerCategory($data);
    }

    /**
     * @param int $id
     * @return \models\bigBrother\SalesPerCategory
     * @throws \Exception
     */
    public static function getSalesPerCategoryById($id){
        $sql = "SELECT id FROM grupeoBigBrother.salesPerCategory WHERE id='%d'";

        $sprintfSql = sprintf($sql, $id);

        try {
            $salesPerCategory = static::getSalesPerCategoryByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $salesPerCategory;
    }

    /**
     * @param int $categoryId
     * @param \models\Interval $interval
     * @return \models\bigBrother\SalesPerCategory
     * @throws \Exception
     */
    public static function getSalesPerCategoryByCategoryId($categoryId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoBigBrother.salesPerCategory WHERE categoryId='%d' AND date >= '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY) ORDER BY quantity DESC";

        $sprintfSql = sprintf($sql,
            $categoryId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $salesPerCategory = static::getSalesPerCategoryByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $salesPerCategory;
    }

    /**
     * @param string $query
     * @return \models\bigBrother\SalesPerCategory
     * @throws \Exception
     */
    private static function getSalesPerCategoryByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataSalesPerCategoryLines = self::fetchAll($queryResource);

            $salesPerCategoryLines = static::generateSalesPerCategoryLines($dataSalesPerCategoryLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $salesPerCategory = static::create();

        $salesPerCategory->setLines($salesPerCategoryLines);

        return $salesPerCategory;
    }

    /**
     * @param Array $dataSalesPerCategoryLines
     * @return \models\bigBrother\SalesPerCategoryLine[]
     * @throws \Exception
     */
    private static function generateSalesPerCategoryLines($dataSalesPerCategoryLines){
        $salesPerCategoryLines = array();

        try {
            foreach ($dataSalesPerCategoryLines as $dataSalesPerCategoryLine){
                $salesPerCategoryLines[] = SalesPerCategoryLineDAO::getSalesPerCategoryLineById($dataSalesPerCategoryLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $salesPerCategoryLines;
    }
}
