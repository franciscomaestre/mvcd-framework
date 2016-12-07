<?php

namespace daos\internal\bigBrother;

class MonthlyDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\Monthly($data);
    }

    /**
     * @param $query
     * @return \models\bigBrother\Monthly
     * @throws \Exception
     */
    private static function getMonthlyByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataMonthlyLines = self::fetchAll($queryResource);

            $monthlyLines = static::generateMonthlyLines($dataMonthlyLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $monthly = static::create();

        $monthly->setLines($monthlyLines);

        return $monthly;
    }

    /**
     * @param Array $dataMonthlyLines
     * @return \models\bigBrother\MonthlyLine[]
     * @throws \Exception
     */
    private static function generateMonthlyLines($dataMonthlyLines){
        $monthlyLines = array();

        try {
            foreach ($dataMonthlyLines as $dataMonthlyLine){
                $monthlyLines[] = MonthlyLineDAO::getMonthlyLineById($dataMonthlyLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $monthlyLines;
    }
}
