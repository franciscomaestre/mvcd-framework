<?php

namespace daos\internal\reports;

class WeeklyDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\Weekly($data);
    }

    /**
     * @param \DateTime $date
     * @return \models\reports\Weekly
     * @throws \Exception
     */
    public static function getWeeklyReportByInitialDate(\DateTime $date){
        $sql = "SELECT id FROM grupeo_reports.dailyReport WHERE date > '%s' AND date <= '%s'";

        $sprintfSql = sprintf($sql, $date->format('Y-m-d'),$date->add(new \DateInterval('P7D'))->format('Y-m-d'));

        try {
            $queryResource = self::select($sprintfSql);

            $dataDailyReports = self::fetchAll($queryResource);

            $dailyReports = static::generateDailyReports($dataDailyReports);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $weeklyReport = static::create();

        $weeklyReport->setLines($dailyReports);

        return $weeklyReport;
    }

    /**
     * @param Array $dataDailyReports
     * @return \models\reports\Daily[]
     * @throws \Exception
     */
    private static function generateDailyReports($dataDailyReports){
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
