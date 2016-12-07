<?php

namespace daos\external\reports;

class EconomicLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\EconomicLine($data);
    }

    /**
     * @param String $economicReportLineId
     * @return \models\reports\EconomicLine
     * @throws \Exception
     */
    public static function getEconomicReportLineById($economicReportLineId) {
        $response = self::execute(URL_SERVER_REPORTS.'/economicReport/getLineById','getLineById',[$economicReportLineId]);
        return \models\reports\EconomicLine::undoSerialize($response);
    }

    /**
     * @param String $orderId
     * @param String $concept
     * @return \models\reports\EconomicLine
     * @throws \Exception
     */
    public static function getEconomicReportLineByOrderIdAndConcept($orderId, $concept) {
        $response = self::execute(URL_SERVER_REPORTS.'/economicReport/getLineByOrderIdAndConcept','getLineById',[$orderId, $concept]);
        return \models\reports\EconomicLine::undoSerialize($response);
    }

    /**
     * @param \models\reports\EconomicLine $economicReport
     * @return String
     * @throws \Exception
     */
    public static function insertEconomicReportLine(\models\reports\EconomicLine $economicReport) {
        $response = self::execute(URL_SERVER_REPORTS.'/economicReport/insertLine','insertLine',[serialize($economicReport)]);
        return unserialize($response);
    }

    /**
     * @param \models\reports\EconomicLine $economicReport
     * @return bool
     * @throws \Exception
     */
    public static function updateEconomicReportLine(\models\reports\EconomicLine $economicReport) {
        $response = self::execute(URL_SERVER_REPORTS.'/economicReport/updateLine','updateLine',[serialize($economicReport)]);
        return unserialize($response);
    }

    /**
     * @param String $economicReportLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteEconomicReportLineById($economicReportLineId) {
        $response = self::execute(URL_SERVER_REPORTS.'/economicReport/deleteLineById','deleteLineById',[$economicReportLineId]);
        return unserialize($response);
    }
}
