<?php

namespace daos\internal\orders;

class MerchantOrderDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\MerchantOrder($data);
    }

    /**
     * @param int $merchantId
     * @param \models\Interval $interval
     * @return \models\orders\MerchantOrder
     * @throws \Exception
     */
    public static function getMerchantOrderByMerchantId($merchantId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoOrders.merchantOrder WHERE merchantId='%d'"
            . " AND dateDelivery > '%s' AND dateDelivery < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $merchantId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $merchantOrder = static::getMerchantOrderByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $merchantOrder;
    }

    /**
     * @param int $merchantId
     * @param \models\Interval $interval
     * @param bool $paid
     * @return \models\orders\MerchantOrder
     * @throws \Exception
     */
    public static function getMerchantOrderByMerchantIdAndPaid($merchantId, \models\Interval $interval, $paid){
        $sql = "SELECT id FROM grupeoOrders.merchantOrder WHERE merchantId='%d'"
            . " AND dateDelivery > '%s' AND dateDelivery < DATE_ADD('%s', INTERVAL 1 DAY) AND paid = '%d'";

        $sprintfSql = sprintf($sql,
            $merchantId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            $paid);

        try {
            $merchantOrder = static::getMerchantOrderByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $merchantOrder;
    }


    /**
     * @param string $query
     * @return \models\orders\MerchantOrder
     * @throws \Exception
     */
    private static function getMerchantOrderByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataMerchantOrderLines = self::fetchAll($queryResource);

            $merchantOrderLines = static::generateMerchantOrderLines($dataMerchantOrderLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $merchantOrder = static::create();

        $merchantOrder->setLines($merchantOrderLines);

        return $merchantOrder;
    }

    /**
     * @param Array $dataMerchantOrderLines
     * @return \models\orders\MerchantOrderLine[]
     * @throws \Exception
     */
    private static function generateMerchantOrderLines($dataMerchantOrderLines){
        $merchantOrderLines = array();

        try {
            foreach ($dataMerchantOrderLines as $dataMerchantOrderLine){
                $merchantOrderLines[] = MerchantOrderLineDAO::getMerchantOrderLineById($dataMerchantOrderLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $merchantOrderLines;
    }

}