<?php

namespace daos\internal\reports;

class EconomicDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\Economic($data);
    }

    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\reports\Economic
     * @throws \Exception
     */
    public static function getEconomicReportByShopId($shopId, \models\Interval $interval){
        $sql = "SELECT er.id FROM grupeoReports.economicReport AS er JOIN grupeoReports.transactionReport AS tr ON tr.orderId = er.orderId AND (tr.status = 'payed' || (tr.status = 'pending' && tr.origin = 'COD'))  WHERE er.shopId='%d' AND er.date > '%s' AND er.date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $economicReport = static::getEconomicReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $economicReport;
    }

    /**
     * @param string $concept
     * @param \models\Interval $interval
     * @return \models\reports\Economic
     * @throws \Exception
     */
    public static function getEconomicReportByConcept($concept, \models\Interval $interval){
        $sql = "SELECT er.id FROM grupeoReports.economicReport AS er JOIN grupeoReports.transactionReport AS tr ON tr.orderId = er.orderId AND (tr.status = 'payed' || (tr.status = 'pending' && tr.origin = 'COD')) WHERE er.concept='%s' AND er.date > '%s' AND er.date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $concept,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $economicReport = static::getEconomicReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $economicReport;
    }

    /**
     * @param Int $shopId
     * @param string $concept
     * @param \models\Interval $interval
     * @return \models\reports\Economic
     * @throws \Exception
     */
    public static function getEconomicReportByShopIdAndConcept($shopId, $concept, \models\Interval $interval){
        $sql = "SELECT er.id FROM grupeoReports.economicReport AS er JOIN grupeoReports.transactionReport AS tr ON tr.orderId = er.orderId AND (tr.status = 'payed' || (tr.status = 'pending' && tr.origin = 'COD')) WHERE er.shopId='%d' AND er.concept='%s' AND er.date > '%s' AND er.date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $concept,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $economicReport = static::getEconomicReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $economicReport;
    }

    /**
     * @param Int $orderId
     * @param \models\Interval $interval
     * @return \models\reports\Economic
     * @throws \Exception
     */
    public static function getEconomicReportByOrderId($orderId,\models\Interval $interval){
        $sql = "SELECT er.id FROM grupeoReports.economicReport AS er JOIN grupeoReports.transactionReport AS tr ON tr.orderId = er.orderId AND (tr.status = 'payed' || (tr.status = 'pending' && tr.origin = 'COD')) WHERE er.orderId='%s' AND er.date > '%s' AND er.date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $orderId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $economicReport = static::getEconomicReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $economicReport;
    }

    /**
     * @param Int $orderId
     * @return \models\reports\Economic
     * @throws \Exception
     */
    public static function getEconomicReportByOrderIdAnytime($orderId){
        $sql = "SELECT id FROM grupeoReports.economicReport WHERE orderId='%s'";

        $sprintfSql = sprintf($sql, $orderId);

        try {
            $economicReport = static::getEconomicReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $economicReport;
    }

    /**
     * @param Int $orderId
     * @param \models\Interval $interval
     * @return \models\reports\Economic
     * @throws \Exception
     */
    public static function getEconomicReportByOrderIdAndConcept($orderId, $concept){
        $sql = "SELECT er.id FROM grupeoReports.economicReport AS er JOIN grupeoReports.transactionReport AS tr ON tr.orderId = er.orderId AND (tr.status = 'payed' || (tr.status = 'pending' && tr.origin = 'COD')) WHERE er.orderId='%s' AND er.concept like '%%s%'";

        $sprintfSql = sprintf($sql,
            $orderId,
            $concept);

        try {
            $economicReport = static::getEconomicReportByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $economicReport;
    }

    /**
     * @param string $query
     * @return \models\reports\Economic
     * @throws \Exception
     */
    private static function getEconomicReportByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataEconomicReportLines = self::fetchAll($queryResource);

            $economicReportlines = static::generateEconomicReportLines($dataEconomicReportLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $economicReport = static::create();

        $economicReport->setLines($economicReportlines);

        return $economicReport;
    }

    /**
     * @param Array $dataEconomicReportLines
     * @return \models\reports\EconomicLine[]
     * @throws \Exception
     */
    private static function generateEconomicReportLines($dataEconomicReportLines){
        $economicReportlines = array();

        try {
            foreach ($dataEconomicReportLines as $dataEconomicReportLine){
                $economicReportlines[] = EconomicLineDAO::getEconomicReportLineById($dataEconomicReportLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $economicReportlines;
    }
}
