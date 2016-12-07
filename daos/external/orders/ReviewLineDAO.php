<?php

namespace daos\external\orders;

class ReviewLineDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\orders\ReviewLine($data);
    }

    /**
     * @param Int $reviewId
     * @return \models\orders\ReviewLine
     */
    public static function getReviewLineById($reviewId) {
        $response = self::execute(URL_SERVER_ORDERS.'/review/getLineById','getLineById',[$reviewId]);
        return \models\orders\ReviewLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\ReviewLine $reviewLine
     * @return int
     */
    public static function insertReviewLineById(\models\orders\ReviewLine $reviewLine) {
        $response = self::execute(URL_SERVER_ORDERS.'/review/insertline','insertLine',[serialize($reviewLine)]);
        return \models\orders\ReviewLine::undoSerialize($response);
    }

    /**
     * @param \models\orders\ReviewLine $reviewLine
     * @return bool
     */
    public static function updateReviewLine(\models\orders\ReviewLine $reviewLine) {
        $response = self::execute(URL_SERVER_ORDERS.'/review/updateLine','updateLine',[serialize($reviewLine)]);
        return \models\orders\ReviewLine::undoSerialize($response);
    }

    /**
     * @param Int $reviewId
     * @return bool
     */
    public static function deleteReviewLineById($reviewId) {
        $response = self::execute(URL_SERVER_ORDERS.'/review/deleteLineById','deleteLineById',[$reviewId]);
        return \models\orders\ReviewLine::undoSerialize($response);
    }

}
