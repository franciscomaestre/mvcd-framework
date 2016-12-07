<?php

namespace daos\internal\shops;

class ShopDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null) {
        return new \models\shops\Shop($data);
    }

    /**
     * @param Int $shopId
     * @return \models\shops\Shop
     * @throws \Exception
     */
    public static function getShopById($shopId) {
        $sql = "SELECT * FROM grupeoShops.shop WHERE id= '%s'";

        $sprintfSql = sprintf($sql, $shopId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataShop = self::fetch($queryResource);

        return static::create($dataShop);
    }

    /**
     * @param String $httpHost
     * @return \models\shops\Shop
     * @throws \Exception
     */
    public static function getShopByHttpHost($httpHost) {
        $sql = "SELECT * FROM grupeoShops.shop WHERE httpHost like '%s'";

        $sprintfSql = sprintf($sql, $httpHost);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataShop = self::fetch($queryResource);

        return static::create($dataShop);
    }

}

