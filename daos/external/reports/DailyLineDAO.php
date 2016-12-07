<?php

namespace daos\external\reports;

class DailyLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\Daily($data);
    }

    /**
     * @param Int $dailyReportId
     * @return \models\reports\Daily
     */
    public static function getDailyReportLineById($dailyReportId) {
        $response = self::execute(URL_SERVER_REPORTS.'/dailyReport/get','get',[$dailyReportId]);
        return \models\reports\Daily::undoSerialize($response);
    }

    /**
     *
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\reports\Daily
     */
    public static function getDailyReportLineByDate($shopId, \DateTime $date) {
        $response = self::execute(URL_SERVER_REPORTS.'/dailyReport/getByDate','getByDate',[$shopId, serialize($date)]);
        return \models\reports\Daily::undoSerialize($response);
    }

    /**
     * @param \models\reports\Daily $dailyReport
     * @return Int
     */
    public static function insertDailyReportLine(\models\reports\Daily $dailyReport) {
        $response = self::execute(URL_SERVER_REPORTS.'/dailyReport/insert','insert',[serialize($dailyReport)]);
        return unserialize($response);
    }

    /**
     * @param \models\reports\Daily $dailyReport
     * @return bool
     */
    public static function updateDailyReportLine(\models\reports\Daily $dailyReport) {
        $response = self::execute(URL_SERVER_REPORTS.'/dailyReport/update','update',[serialize($dailyReport)]);
        return unserialize($response);
    }

    /**
     * @param Int $dailyReportId
     * @return bool
     */
    public static function deleteDailyReportLineById($dailyReportId) {
        $response = self::execute(URL_SERVER_REPORTS.'/dailyReport/delete','delete',[$dailyReportId]);
        return unserialize($response);
    }
}
