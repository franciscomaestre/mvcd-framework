<?php

namespace daos\external\reports;

class TransactionLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\reports\TransactionLine($data);
    }

    /**
     * @param Int $transactionReportLineId
     * @return \models\reports\TransactionLine
     */
    public static function getTransactionReportLineById($transactionReportLineId) {
        $response = self::execute(URL_SERVER_REPORTS.'/transactionReport/getLineById','getLineById',[$transactionReportLineId]);
        return \models\reports\TransactionLine::undoSerialize($response);
    }

    /**
     * @param \models\reports\TransactionLine $transactionReportLine
     * @return Int
     */
    public static function insertTransactionReportLine($transactionReportLine) {
        $response = self::execute(URL_SERVER_REPORTS.'/transactionReport/insertLine','insertLine',[serialize($transactionReportLine)]);
        return unserialize($response);
    }

    /**
     * @param \models\reports\TransactionLine $transactionReportLine
     * @return bool
     */
    public static function updateTransactionReportLine($transactionReportLine) {
        $response = self::execute(URL_SERVER_REPORTS.'/transactionReport/updateLine','updateLine',[serialize($transactionReportLine)]);
        return unserialize($response);
    }

    /**
     * @param Int $transactionReportLineId
     * @return bool
     */
    public static function deleteTransactionReportLineById($transactionReportLineId) {
        $response = self::execute(URL_SERVER_REPORTS.'/transactionReport/deleteLineById','deleteLineById',[$transactionReportLineId]);
        return unserialize($response);
    }


}
