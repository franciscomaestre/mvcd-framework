<?php

namespace daos\internal\shops;

class GrupeoCommissionLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\shops\GrupeoCommissionLine($data);
    }

    /**
     * @param int $grupeoCommissionLineId
     * @return \models\shops\GrupeoCommissionLine
     * @throws \Exception
     */
    public static function getGrupeoCommissionLineById($grupeoCommissionLineId) {

        $sql = "SELECT * FROM grupeoShops.grupeoCommission WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $grupeoCommissionLineId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataCommissionId = self::fetch($queryResource);

        return self::create($dataCommissionId);

    }

    /**
     * @param \models\shops\GrupeoCommissionLine $grupeoCommissionLine
     * @return int
     * @throws \Exception
     */
    public static function insertGrupeoCommissionLine($grupeoCommissionLine) {

        $sql = "INSERT INTO grupeoShops.grupeoCommission (shopId,initialRange,endRange,percentage)"
            . "VALUES ('%s','%s','%s','%s')";

        $sprintfSql = sprintf($sql,
            $grupeoCommissionLine->getShopId(),
            $grupeoCommissionLine->getInitialRange(),
            $grupeoCommissionLine->getEndRange(),
            $grupeoCommissionLine->getPercentage()
            );

        try {
            $lastInsertedId = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastInsertedId;

    }

    /**
     * @param \models\shops\GrupeoCommissionLine $grupeoCommissionLine
     * @return bool
     * @throws \Exception
     */
    public static function updateGrupeoCommissionLine($grupeoCommissionLine) {

        $sql = "UPDATE grupeoShops.grupeoCommission"
            . " SET shopId= '%d', initialRange = '%.0f', endRange = '%.0f', percentage = '%.0f'"
            . " WHERE id = '%d'";

        $sprintfSql = sprintf($sql,
            $grupeoCommissionLine->getShopId(),
            $grupeoCommissionLine->getInitialRange(),
            $grupeoCommissionLine->getEndRange(),
            $grupeoCommissionLine->getPercentage(),
            $grupeoCommissionLine->getId()
        );

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;

    }

    /**
     * @param int $grupeoCommissionLineId
     * @return bool
     * @throws \Exception
     */
    public static function deleteGrupeoCommissionLineById($grupeoCommissionLineId) {

        $sql = "DELETE FROM grupeoShops.grupeoCommission WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $grupeoCommissionLineId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;

    }
}
