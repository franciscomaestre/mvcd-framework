<?php

namespace daos\external\reports;

class DailyDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\Daily($data);
    }

    public static function getDailyReportByYearAndMonthAndDay($year, $month, $day) {
        $response = self::execute(URL_SERVER_REPORTS.'/dailyReport/getByYearAndMonthAndDay','getByYearAndMonthAndDay',[$year,$month,$day]);
        return \models\reports\Daily::undoSerialize($response);
    }
}
