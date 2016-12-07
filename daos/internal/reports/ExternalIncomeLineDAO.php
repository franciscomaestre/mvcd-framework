<?php

namespace daos\internal\reports;

class ExternalIncomeLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\reports\ExternalIncomeLine($data);
    }

    /**
     * @param String $externalIncomeLineId
     * @return \ExternalIncomeLine
     * @throws \Exception
     */
    public static function getExternalIncomeLineById($externalIncomeLineId) {
        $sql = "SELECT * FROM grupeoReports.externalIncome WHERE id= '%s'";

        $sprintfSql = sprintf($sql, $externalIncomeLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\reports\ExternalIncomeLine $externalIncome
     * @return Int
     * @throws \Exception
     */
    public static function insertExternalIncomeLine(\models\reports\ExternalIncomeLine $externalIncome) {
        $sql = "INSERT grupeoReports.externalIncome (id,shopId,concept,origin,amount,orderId,date)"
            . " VALUES ('%s','%d','%s','%.0f','%s',NOW())";

        $sprintfSql = sprintf($sql,
            \DbConnector::getInstance()->generateId(),
            $externalIncome->getShopId(),
            $externalIncome->getConcept(),
            $externalIncome->getOrigin(),
            $externalIncome->getAmount()->getValueInCents(),
            $externalIncome->getOrderId());

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\reports\ExternalIncomeLine $externalIncome
     * @return bool
     * @throws \Exception
     */
    public static function updateExternalIncomeLine(\models\reports\ExternalIncomeLine $externalIncomeLine) {
        $sql = "UPDATE grupeoReports.externalIncome"
            . "SET shopId = '%d',concept = '%s', origin = '%s', amount = '%.0f',orderId = '%s',date = '%s' WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $externalIncomeLine->getShopId(),
            $externalIncomeLine->getConcept(),
            $externalIncomeLine->getOrigin(),
            $externalIncomeLine->getAmount()->getValueInCents(),
            $externalIncomeLine->getOrderId(),
            $externalIncomeLine->getDate()->format('Y-m-d H:i:s'),
            $externalIncomeLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param String $externalIncomeLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteExternalIncomeReportLineById($externalIncomeLineId) {
        $sql = "DELETE FROM grupeoReports.externalIncome WHERE id='%s'";

        $sprintfSql = sprintf($sql, $externalIncomeLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $isDeleted;
    }
}
