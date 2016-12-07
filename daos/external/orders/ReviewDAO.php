<?php

namespace daos\external\orders;

class ReviewDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\Review($data);
    }

    /**
     * @param int $starsQuantity
     * @return \models\orders\Review
     * @throws \Exception
     */
    public static function getReviewByStarsQuantity($starsQuantity){
        $response = self::execute(URL_SERVER_ORDERS.'/review/getByStarsQuantity','getByStarsQuantity',[$starsQuantity]);
        return \models\orders\Review::undoSerialize($response);
    }

}
