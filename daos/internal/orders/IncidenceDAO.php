<?php

namespace daos\internal\orders;

class IncidenceDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\Incidence($data);
    }

    /**
     * @param string $orderId
     * @return \models\orders\Incidence
     * @throws \Exception
     */
    public static function getIncidenceByOrderId($orderId){
        $sql = "SELECT id FROM grupeoOrders.incidence WHERE orderId='%s'";

        $sprintfSql = sprintf($sql,$orderId);

        try {
            $incidence = static::getIncidenceByQuery($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $incidence;
    }

    /**
     * @param string $query
     * @return \models\orders\Incidence
     * @throws \Exception
     */
    private static function getIncidenceByQuery($query){
        try {
            $queryResource = self::select($query);

            $dataIncidenceLines = self::fetchAll($queryResource);

            $incidenceLines = static::generateIncidenceLines($dataIncidenceLines);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $incidence = static::create();

        $incidence->setLines($incidenceLines);

        return $incidence;
    }

    /**
     * @param Array $dataIncidenceLines
     * @return \models\orders\IncidenceLine[]
     * @throws \Exception
     */
    private static function generateIncidenceLines($dataIncidenceLines){
        $incidenceLines = array();

        try {
            foreach ($dataIncidenceLines as $dataIncidenceLine){
                $incidenceLines[] = IncidenceLineDAO::getIncidenceLineById($dataIncidenceLine['id']);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $incidenceLines;
    }

}