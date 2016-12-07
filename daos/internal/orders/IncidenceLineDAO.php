<?php

namespace daos\internal\orders;

use models\orders\ProductIncidence;

class IncidenceLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\IncidenceLine($data);
    }

    /**
     * @param Int $incidenceId
     * @return \models\orders\IncidenceLine
     * @throws \Exception
     */
    public static function getIncidenceLineById($incidenceId) {
        $sql = "SELECT * FROM grupeoOrders.incidence WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $incidenceId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        $incidenceLine = static::create($data);

        $incidenceLine->setProductIncidence(ProductIncidenceDAO::getProductIncidenceByIncidenceId($incidenceLine->getId()));

        return $incidenceLine;
    }

    /**
     * @param \models\orders\IncidenceLine $incidenceLine
     * @return int
     * @throws \Exception
     */
    public static function insertIncidenceLine(\models\orders\IncidenceLine $incidenceLine) {

        $sql = "INSERT grupeoOrders.incidence (orderId, email, phone) VALUES ('%s','%s','%s')";

        $sprintfSql = sprintf($sql, $incidenceLine->getorderId(), $incidenceLine->getEmail(), $incidenceLine->getPhone());

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\orders\IncidenceLine $incidenceLine
     * @return bool
     * @throws \Exception
     */
    public static function updateIncidenceLine(\models\orders\IncidenceLine $incidenceLine) {
        $sql = "UPDATE grupeoOrders.incidence SET orderId = '%s', email = '%s', phone = '%s' WHERE id = '%d'";

        $sprintfSql = sprintf($sql,
            $incidenceLine->getorderId(),
            $incidenceLine->getEmail(),
            $incidenceLine->getPhone(),
            $incidenceLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param Int $incidenceId
     * @return bool
     * @throws \Exception
     */
    public static function deleteIncidenceLineById($incidenceId) {
        $sql = "DELETE FROM grupeoOrders.incidence WHERE id = '%d'";

        $sprintfSql = sprintf($sql, $incidenceId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;
    }

}