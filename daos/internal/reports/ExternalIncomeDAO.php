<?php

namespace daos\internal\reports;

class ExternalIncomeDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\ExternalIncome($data);
    }

    /**
     * @param Int $shopId
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     * @throws \Exception
     */
    public static function getExternalIncomeByShopId($shopId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.externalIncome WHERE shopId='%d' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $externalIncome = static::getExternalIncomeByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $externalIncome;
    }

    /**
     * @param string $concept
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     * @throws \Exception
     */
    public static function getExternalIncomeByConcept($concept, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.externalIncome WHERE concept='%s' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $concept,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $externalIncome = static::getExternalIncomeByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $externalIncome;
    }

    /**
     * @param Int $shopId
     * @param string $concept
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     * @throws \Exception
     */
    public static function getExternalIncomeByShopIdAndConcept($shopId, $concept, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.externalIncome WHERE shopId='%d' AND concept='%s' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $concept,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $externalIncome = static::getExternalIncomeByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $externalIncome;
    }

    /**
     * @param string $origin
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     * @throws \Exception
     */
    public static function getExternalIncomeByOrigin($origin, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.externalIncome WHERE origin LIKE %'%s'% AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $origin,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $externalIncome = static::getExternalIncomeByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $externalIncome;
    }

    /**
     * @param Int $orderId
     * @param \models\Interval $interval
     * @return \models\reports\ExternalIncome
     * @throws \Exception
     */
    public static function getExternalIncomeByOrderId($orderId,\models\Interval $interval){
        $sql = "SELECT id FROM grupeoReports.externalIncome WHERE orderId='%s' AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $orderId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $externalIncome = static::getExternalIncomeByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $externalIncome;
    }

    /**
     * @param string $query
     * @return \models\reports\ExternalIncome
     * @throws \Exception
     */
    private static function getExternalIncomeByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataExternalIncomeLines = self::fetchAll($queryResource);

            $externalIncomelines = static::generateExternalIncomeLines($dataExternalIncomeLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $externalIncome = static::create();

        $externalIncome->setLines($externalIncomelines);

        return $externalIncome;
    }

    /**
     * @param Array $dataExternalIncomeLines
     * @return \models\reports\ExternalIncomeLine[]
     * @throws \Exception
     */
    private static function generateExternalIncomeLines($dataExternalIncomeLines){
        $externalIncomelines = array();

        try {
            foreach ($dataExternalIncomeLines as $dataExternalIncomeLine){
                $externalIncomelines[] = ExternalIncomeLineDAO::getExternalIncomeLineById($dataExternalIncomeLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $externalIncomelines;
    }
}
