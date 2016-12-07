<?php

namespace daos\external\shops;

class GrupeoCommissionLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\shops\GrupeoCommissionLine($data);
    }

    /**
     * @param int $grupeoCommissionLineId
     * @return \models\shops\GrupeoCommissionLine
     */
    public static function getGrupeoCommissionLineById($grupeoCommissionLineId) {
        $response = self::execute(URL_SERVER_SHOPS.'/grupeoCommission/getLineById','getById',[$grupeoCommissionLineId]);
        return \models\shops\GrupeoCommissionLine::undoSerialize($response);
    }

    /**
     * @param \models\shops\GrupeoCommissionLine $grupeoCommissionLine
     * @return int
     */
    public static function insertGrupeoCommissionLine($grupeoCommissionLine) {
        $response = self::execute(URL_SERVER_SHOPS.'/grupeoCommission/insertLine','insertLine',[serialize($grupeoCommissionLine)]);
        return unserialize($response);
    }

    /**
     * @param \models\shops\GrupeoCommissionLine $grupeoCommissionLine
     * @return bool
     */
    public static function updateGrupeoCommissionLine($grupeoCommissionLine) {
        $response = self::execute(URL_SERVER_SHOPS.'/grupeoCommission/updateLine','updateLine',[serialize($grupeoCommissionLine)]);
        return unserialize($response);
    }

    /**
     * @param int $grupeoCommissionLineId
     * @return bool
     */
    public static function deleteGrupeoCommissionLineById($grupeoCommissionLineId) {
        $response = self::execute(URL_SERVER_SHOPS.'/grupeoCommission/deleteById','deleteById',[$grupeoCommissionLineId]);
        return unserialize($response);
    }
}
