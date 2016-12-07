<?php

namespace daos\internal\orders;

class MerchantOrderLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\MerchantOrderLine($data);
    }

    /**
     * @param Int $merchantOrderId
     * @return \models\orders\MerchantOrderLine
     * @throws \Exception
     */
    public static function getMerchantOrderLineById($merchantOrderId) {
        $sql = "SELECT * FROM grupeoOrders.merchantOrder WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $merchantOrderId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\orders\MerchantOrderLine $merchantOrderLine
     * @return int
     * @throws \Exception
     */
    public static function insertMerchantOrderLine(\models\orders\MerchantOrderLine $merchantOrderLine) {

        $sql = "INSERT grupeoOrders.merchantOrder (merchantId, dateDelivery, paid, comments) VALUES ('%d','%s','%d','%s')";

        $sprintfSql = sprintf($sql,
            $merchantOrderLine->getMerchantId(),
            $merchantOrderLine->getDateDelivery()->format('Y-m-d H:i:s'),
            $merchantOrderLine->getPaid(),
            $merchantOrderLine->getComments());

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\orders\MerchantOrderLine $merchantOrderLine
     * @return bool
     * @throws \Exception
     */
    public static function updateMerchantOrderLine(\models\orders\MerchantOrderLine $merchantOrderLine) {
        $sql = "UPDATE grupeoOrders.merchantOrder SET merchantId = '%d', dateDelivery = '%s', paid = '%d', comments = '%s' WHERE id = '%d'";

        $sprintfSql = sprintf($sql,
            $merchantOrderLine->getMerchantId(),
            $merchantOrderLine->getDateDelivery()->format('Y-m-d H:i:s'),
            $merchantOrderLine->getPaid(),
            $merchantOrderLine->getComments(),
            $merchantOrderLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param Int $merchantOrderId
     * @return bool
     * @throws \Exception
     */
    public static function deleteMerchantOrderLineById($merchantOrderId) {
        $sql = "DELETE FROM grupeoOrders.merchantOrder WHERE id = '%d'";

        $sprintfSql = sprintf($sql, $merchantOrderId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;
    }

}