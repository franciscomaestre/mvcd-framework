<?php

namespace daos\external\orders;

class IncidenceDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\Incidence($data);
    }

    /**
     * @param string $orderId
     * @return \models\orders\Incidence
     */
    public static function getIncidenceByOrderId($orderId){
        $response = self::execute(URL_SERVER_REPORTS.'/incidence/getByOrderId','getByOrderId',[$orderId]);
        return \models\orders\Incidence::undoSerialize($response);
    }

}