<?php

namespace daos\external\reports;

class WeeklyDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\Weekly($data);
    }

    /**
     * @param \DateTime $date
     * @return \models\reports\Weekly
     * @throws \Exception
     */
    public static function getWeeklyReportByInitialDate(\DateTime $date){
        $response = self::execute(URL_SERVER_REPORTS.'/WeeklyReport/get','get',[$date]);
        return \models\reports\Weekly::undoSerialize($response);
    }

}
