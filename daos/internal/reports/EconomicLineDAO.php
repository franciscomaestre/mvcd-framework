<?php

namespace daos\internal\reports;

class EconomicLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\EconomicLine($data);
    }

    /**
     * @param String $economicReportLineId
     * @return \models\reports\EconomicLine
     * @throws \Exception
     */
    public static function getEconomicReportLineById($economicReportLineId) {
        $sql = "SELECT * FROM grupeoReports.economicReport WHERE id= '%s'";

        $sprintfSql = sprintf($sql, $economicReportLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param String $economicReportLineId
     * @return \models\reports\EconomicLine
     * @throws \Exception
     */
    public static function getEconomicReportLineByOrderIdAndConcept($orderId, $concept) {
        $sql = "SELECT * FROM grupeoReports.economicReport WHERE orderId= '%s' AND concept like '%%%s%%' order by `date` desc LIMIT 1";

        $sprintfSql = sprintf($sql, $orderId, $concept);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\reports\EconomicLine $economicReport
     * @return String
     * @throws \Exception
     */
    public static function insertEconomicReportLine(\models\reports\EconomicLine $economicReport) {
        $sql = "INSERT grupeoReports.economicReport (id,shopId,concept,amount,orderId,date)"
                . " VALUES ('%s','%d','%s','%.0f','%s','%s')";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $economicReport->getShopId(),
            $economicReport->getConcept(),
            $economicReport->getAmount()->getValueInCents(),
            $economicReport->getOrderId(),
            $economicReport->getDate()->format('Y-m-d H:i:s'));

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\reports\EconomicLine $economicReport
     * @return bool
     * @throws \Exception
     */
    public static function updateEconomicReportLine(\models\reports\EconomicLine $economicReport) {
        $sql = "UPDATE grupeoReports.economicReport"
                . " SET shopId = '%d',concept = '%s',amount = '%.0f',orderId = '%s',date = '%s' WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $economicReport->getShopId(),
            $economicReport->getConcept(),
            $economicReport->getAmount()->getValueInCents(),
            $economicReport->getOrderId(),
            $economicReport->getDate()->format('Y-m-d H:i:s'),
            $economicReport->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $economicReportLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteEconomicReportLineById($economicReportLineId) {
        $sql = "DELETE FROM grupeoReports.economicReport WHERE id='%s'";

        $sprintfSql = sprintf($sql, $economicReportLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $isDeleted;
    }
}
