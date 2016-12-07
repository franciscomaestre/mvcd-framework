<?php

namespace daos\internal\bigBrother;

class TopCategoryLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\bigBrother\TopCategoryLine($data);
    }

    /**
     * @param array $data
     * @return \models\bigBrother\TopCategoryLine
     * @throws \Exception
     */
    public static function getTopCategoryLine($data){
        $response = self::execute(URL_SERVER_BIGBROTHER.'/topCategory/getLine','getLine',[serialize($data)]);
        return \models\bigBrother\TopCategoryLine::undoSerialize($response);
    }
}
