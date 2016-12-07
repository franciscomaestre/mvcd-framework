<?php

namespace daos\internal\bigBrother;

class DailyDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\Daily($data);
    }

    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\bigBrother\Daily
     * @throws \Exception
     */
    public static function getDailyByShopId($shopId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoBigBrother.dailyBigBrother WHERE shopId = '%d' AND date >= '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $daily = static::getDailyByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $daily;
    }

    /**
     * @param $query
     * @return \models\bigBrother\Daily
     * @throws \Exception
     */
    private static function getDailyByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataDailyLines = self::fetchAll($queryResource);

            $dailyLines = static::generateDailyLines($dataDailyLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $daily = static::create();

        $daily->setLines($dailyLines);

        return $daily;
    }

    /**
     * @param Array $dataDailyLines
     * @return \models\bigBrother\DailyLine[]
     * @throws \Exception
     */
    private static function generateDailyLines($dataDailyLines){
        $dailyLines = array();

        try {
            foreach ($dataDailyLines as $dataDailyLine){
                $dailyLines[] = DailyLineDAO::getDailyLineById($dataDailyLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $dailyLines;
    }
}
