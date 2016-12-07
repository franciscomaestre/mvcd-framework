<?php

namespace daos\external\orders;

class IncidenceLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\IncidenceLine($data);
    }

    /**
     * @param Int $incidenceId
     * @return \models\orders\IncidenceLine
     */
    public static function getIncidenceLineById($incidenceId) {
        $response = self::execute(URL_SERVER_REPORTS.'/incidence/getLineById','getLineById',[$incidenceId]);
        return \models\orders\IncidenceLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\IncidenceLine $incidenceLine
     * @return int
     */
    public static function insertIncidenceLine(\models\orders\IncidenceLine $incidenceLine) {
        $response = self::execute(URL_SERVER_REPORTS.'/incidence/insertLine','insertLine',[serialize($incidenceLine)]);
        return \models\orders\IncidenceLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\IncidenceLine $incidenceLine
     * @return bool
     * @throws \Exception
     */
    public static function updateIncidenceLine(\models\orders\IncidenceLine $incidenceLine) {
        $response = self::execute(URL_SERVER_REPORTS.'/incidence/updateLine','updateLine',[serialize($incidenceLine)]);
        return \models\orders\IncidenceLine::undoSerialize($response);
    }

    /**
     * @param Int $incidenceId
     * @return bool
     * @throws \Exception
     */
    public static function deleteIncidenceLineById($incidenceId) {
        $response = self::execute(URL_SERVER_REPORTS.'/incidence/deleteLineById','deleteLineById',[$incidenceId]);
        return \models\orders\IncidenceLine::undoSerialize($response);
    }
}
