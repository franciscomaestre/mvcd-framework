<?php

namespace daos\external\reports;

class ExternalIncomeLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\ExternalIncomeLine($data);
    }

    /**
     * @param String $externalIncomeLineId
     * @return \models\reports\ExternalIncomeLine
     * @throws \Exception
     */
    public static function getExternalIncomeLineById($externalIncomeLineId) {
        $response = self::execute(URL_SERVER_REPORTS.'/externalIncome/getLineById','getLineById',[$externalIncomeLineId]);
        return \models\reports\ExternalIncomeLine::undoSerialize($response);
    }

    /**
     * @param \models\reports\ExternalIncomeLine $externalIncome
     * @return Int
     * @throws \Exception
     */
    public static function insertExternalIncomeLine(\models\reports\ExternalIncomeLine $externalIncome) {
        $response = self::execute(URL_SERVER_REPORTS.'/externalIncome/insertLine','insertLine',[serialize($externalIncome)]);
        return unserialize($response);
    }

    /**
     * @param \models\reports\ExternalIncomeLine $externalIncome
     * @return bool
     * @throws \Exception
     */
    public static function updateExternalIncomeLine(\models\reports\ExternalIncomeLine $externalIncome) {
        $response = self::execute(URL_SERVER_REPORTS.'/externalIncome/updateLine','updateLine',[serialize($externalIncome)]);
        return unserialize($response);
    }

    /**
     * @param String $externalIncomeLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteExternalIncomeReportLineById($externalIncomeLineId) {
        $response = self::execute(URL_SERVER_REPORTS.'/externalIncome/deleteLineById','deleteLineById',[$externalIncomeLineId]);
        return unserialize($response);
    }
}
