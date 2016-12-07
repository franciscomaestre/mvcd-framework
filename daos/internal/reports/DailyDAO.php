<?php

namespace daos\internal\reports;

class DailyDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\Daily($data);
    }

    /**
     * @param Int $year
     * @param Int $month
     * @return \models\reports\Daily
     * @throws \Exception
     */
    public static function getDailyReportByYearAndMonthAndDay($year, $month, $day){
        $sql = "SELECT id FROM grupeoReports.dailyReport WHERE YEAR(date) = '%s' AND MONTH(date) = '%s' AND DAY(date) = '%s'";

        $sprintfSql = sprintf($sql, $year, $month, $day);

        try {
            $queryResource = self::select($sprintfSql);

            $dataDailyReports = self::fetchAll($queryResource);

            $dailyReports = static::generateDailyReportLines($dataDailyReports);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $monthlyReport = static::create();

        $monthlyReport->setLines($dailyReports);

        return $monthlyReport;
    }

    /**
     * @param Array $dataDailyReports
     * @return \models\reports\DailyLine[]
     * @throws \Exception
     */
    private static function generateDailyReportLines($dataDailyReports){
        $dailyReports = array();

        try {
            foreach ($dataDailyReports as $dataDailyReport){
                $dailyReports[] = DailyDAO::getDailyReportById($dataDailyReport['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $dailyReports;
    }

}
