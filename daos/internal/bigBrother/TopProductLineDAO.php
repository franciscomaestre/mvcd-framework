<?php

namespace daos\internal\bigBrother;

class TopProductLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\TopProductLine($data);
    }

    /**
     * @param array $data
     * @return \models\bigBrother\TopProductLine
     * @throws \Exception
     */
    public static function getTopProductLine($data){
        return static::create($data);
    }
}
