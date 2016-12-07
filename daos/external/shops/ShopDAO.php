<?php

namespace daos\external\shops;

class ShopDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\shops\Shop($data);
    }

    /**
     * @param Int $shopId
     * @return \models\shops\Shop
     * @throws \Exception
     */
    public static function getShopById($shopId) {
        $response = self::execute(URL_SERVER_SHOPS.'/shop/getById','getById',[$shopId]);
        return \models\shops\Shop::undoSerialize($response);
    }

    /**
     * @param String $httpHost
     * @return \models\shops\Shop
     * @throws \Exception
     */
    public static function getShopByHttpHost($httpHost) {
        $response = self::execute(URL_SERVER_SHOPS.'/shop/getByHttpHost','getByHttpHost',[$httpHost]);
        return \models\shops\Shop::undoSerialize($response);
    }

}
