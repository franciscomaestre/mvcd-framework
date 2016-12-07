<?php

namespace daos\internal\orders;

class ProductIncidenceDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\ProductIncidence($data);
    }

    /**
     * @param int $shopId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByShopId($shopId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE shopId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param int $shopId
     * @param int $incidenceId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByShopIdAndIncidenceId($shopId, $incidenceId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE shopId = '%d' AND incidenceId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $shopId,
            $incidenceId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param int $incidenceId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByIncidenceId($incidenceId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE incidenceId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $incidenceId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param int $productId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByProductId($productId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE productId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $productId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param int $merchantId
     * @param \models\Interval $interval
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByMerchantId($merchantId, \models\Interval $interval){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE merchantId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY)";

        $sprintfSql = sprintf($sql,
            $merchantId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'));

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param int $shopId
     * @param \models\Interval $interval
     * @param bool $solved
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByShopIdAndSolved($shopId, \models\Interval $interval, $solved){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE shopId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY) AND solved = '%d'";

        $sprintfSql = sprintf($sql,
            $shopId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            ($solved) ? 1 : 0);

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param int $shopId
     * @param int $incidenceId
     * @param \models\Interval $interval
     * @param bool $solved
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByShopIdAndIncidenceIdAndSolved($shopId, $incidenceId, \models\Interval $interval, $solved){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE shopId = '%d' AND incidenceId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY) AND solved = '%d'";

        $sprintfSql = sprintf($sql,
            $shopId,
            $incidenceId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            ($solved) ? 1 : 0);

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param int $incidenceId
     * @param \models\Interval $interval
     * @param bool $solved
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByIncidenceIdAndSolved($incidenceId, \models\Interval $interval, $solved){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE incidenceId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY) AND solved = '%d'";

        $sprintfSql = sprintf($sql,
            $incidenceId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            ($solved) ? 1 : 0);

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param int $productId
     * @param \models\Interval $interval
     * @param bool $solved
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByProductIdAndSolved($productId, \models\Interval $interval, $solved){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE productId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY) AND solved = '%d'";

        $sprintfSql = sprintf($sql,
            $productId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            ($solved) ? 1 : 0);

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param int $merchantId
     * @param \models\Interval $interval
     * @param bool $solved
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    public static function getProductIncidenceByMerchantIdAndSolved($merchantId, \models\Interval $interval, $solved){
        $sql = "SELECT id FROM grupeoOrders.productIncidence WHERE merchantId = '%d'"
            . " AND date > '%s' AND date < DATE_ADD('%s', INTERVAL 1 DAY) AND solved = '%d'";

        $sprintfSql = sprintf($sql,
            $merchantId,
            $interval->getInitialDate()->format('Y-m-d'),
            $interval->getEndDate()->format('Y-m-d'),
            ($solved) ? 1 : 0);

        try {
            $productIncidence = static::getProductIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $productIncidence;
    }

    /**
     * @param string $query
     * @return \models\orders\ProductIncidence
     * @throws \Exception
     */
    private static function getProductIncidenceByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataProductIncidenceLines = self::fetchAll($queryResource);

            $productIncidenceLines = static::generateProductIncidenceLines($dataProductIncidenceLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $productIncidence = static::create();

        $productIncidence->setLines($productIncidenceLines);

        return $productIncidence;
    }

    /**
     * @param Array $dataProductIncidenceLines
     * @return \models\orders\ProductIncidenceLine[]
     * @throws \Exception
     */
    private static function generateProductIncidenceLines($dataProductIncidenceLines){
        $productIncidenceLines = array();

        try {
            foreach ($dataProductIncidenceLines as $dataProductIncidenceLine){
                $productIncidenceLines[] = ProductIncidenceLineDAO::getProductIncidenceLineById($dataProductIncidenceLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $productIncidenceLines;
    }

}