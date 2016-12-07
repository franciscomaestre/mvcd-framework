<?php

namespace daos\internal\shops;

class GrupeoCommissionDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\shops\GrupeoCommission($data);
    }

    /**
     * @param int $shopId
     * @return \models\shops\GrupeoCommission
     * @throws \Exception
     */
    public static function getGrupeoCommissionByShopId($shopId) {

        $sql = "SELECT id FROM grupeoShops.grupeoCommission"
            . " WHERE shopId = '%s'";

        $sprintfSql = sprintf($sql,$shopId);

        try {
            $grupeoCommission = static::getGrupeoCommissionByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $grupeoCommission;
    }

    /**
     * @param int $shopId
     * @return \models\shops\GrupeoCommission
     * @throws \Exception
     */
    public static function getGrupeoCommissionByShopIdAndAmount($shopId,\models\Money $amount) {

        $sql = "SELECT id FROM grupeoShops.grupeoCommission"
            . " WHERE shopId = '%s'"
            . " AND initialRange < '%.0f'"
            . " AND endRange >= '%.0f'";

        $sprintfSql = sprintf($sql,$shopId,$amount->getValueInCents(),$amount->getValueInCents());

        try {
            $grupeoCommission = static::getGrupeoCommissionByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $grupeoCommission;
    }

    /**
     * @param string $query
     * @return \models\shops\GrupeoCommission
     * @throws \Exception
     */
    private static function getGrupeoCommissionByQuery($query) {
        try {
            $queryResource = self::select($query);

            $arrayIds = self::fetchAll($queryResource);

            $grupeoCommissionLines = static::generateGrupeoCommissionLines($arrayIds);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $grupeoCommission = self::create();

        $grupeoCommission->setLines($grupeoCommissionLines);

        return $grupeoCommission;
    }

    /**
     * @param int[] $arrayIds
     * @return \models\shops\GrupeoCommissionLine[]
     * @throws \Exception
     */
    private static function generateGrupeoCommissionLines($arrayIds) {
        $grupeoCommissionLines = array();

        try {
            foreach($arrayIds as $dataCommission) {
                $grupeoCommissionLines[] = GrupeoCommissionLineDAO::getGrupeoCommissionLineById($dataCommission['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $grupeoCommissionLines;

    }
}
