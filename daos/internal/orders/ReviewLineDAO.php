<?php

namespace daos\internal\orders;

class ReviewLineDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\orders\ReviewLine($data);
    }

    /**
     * @param Int $reviewId
     * @return \models\orders\ReviewLine
     * @throws \Exception
     */
    public static function getReviewLineById($reviewId) {
        $sql = "SELECT * FROM grupeoOrders.review WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $reviewId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param \models\orders\ReviewLine $reviewLine
     * @return int
     * @throws \Exception
     */
    public static function insertReviewLine(\models\orders\ReviewLine $reviewLine) {

        $sql = "INSERT grupeoOrders.review (starsQuantity, comments) VALUES ('%d','%s')";

        $sprintfSql = sprintf($sql, $reviewLine->getStarsQuantity(), $reviewLine->getComments());

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\orders\ReviewLine $reviewLine
     * @return bool
     * @throws \Exception
     */
    public static function updateReviewLine(\models\orders\ReviewLine $reviewLine) {
        $sql = "UPDATE grupeoOrders.review SET starsQuantity = '%s', comments = '%d' WHERE id = '%d'";

        $sprintfSql = sprintf($sql, $reviewLine->getStarsQuantity(), $reviewLine->getComments(), $reviewLine->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param Int $reviewId
     * @return bool
     * @throws \Exception
     */
    public static function deleteReviewLineById($reviewId) {
        $sql = "DELETE FROM grupeoOrders.review WHERE id = '%d'";

        $sprintfSql = sprintf($sql, $reviewId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;
    }

}