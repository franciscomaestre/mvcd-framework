<?php

namespace daos\external\bigBrother;

class TopProductLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\bigBrother\TopProductLine($data);
    }

    /**
     * @param array $data
     * @return \models\bigBrother\TopProductLine
     * @throws \Exception
     */
    public static function getTopProductLine($data){
        $response = self::execute(URL_SERVER_BIGBROTHER.'/topProduct/getLine','getLine',[serialize($data)]);
        return \models\bigBrother\TopProductLine::undoSerialize($response);
    }
}
