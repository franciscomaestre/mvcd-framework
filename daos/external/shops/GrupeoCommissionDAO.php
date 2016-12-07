<?php

namespace daos\external\shops;

class GrupeoCommissionDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\shops\GrupeoCommission($data);
    }

    /**
     * @param int $shopId
     * @return \models\shops\GrupeoCommission
     */
    public static function getGrupeoCommissionByShopId($shopId) {
        $response = self::execute(URL_SERVER_SHOPS.'/grupeoCommission/getByShopId','getByShopId',[$shopId]);
        return \models\shops\GrupeoCommission::undoSerialize($response);
    }

    /**
     * @param int $shopId
     * @return \models\shops\GrupeoCommission
     */
    public static function getGrupeoCommissionByShopIdAndAmount($shopId,\models\Money $amount) {
        $response = self::execute(URL_SERVER_SHOPS.'/grupeoCommission/getByShopIdAndAmount','getByShopIdAndAmount',[$shopId,serialize($amount)]);
        return \models\shops\GrupeoCommission::undoSerialize($response);
    }

}
