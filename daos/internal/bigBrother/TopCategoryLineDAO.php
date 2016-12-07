<?php

namespace daos\internal\bigBrother;

class TopCategoryLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\bigBrother\TopCategoryLine($data);
    }

    /**
     * @param array $data
     * @return \models\bigBrother\TopCategoryLine
     * @throws \Exception
     */
    public static function getTopCategoryLine($data){
        return static::create($data);
    }
}
