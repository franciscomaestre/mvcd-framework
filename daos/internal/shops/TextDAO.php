<?php

namespace daos\internal\shops;

class TextDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\shops\Text($data);
    }

    /**
     * @param int $textId
     * @return \models\shops\Text
     * @throws \Exception
     */
    public static function getTextById($textId) {

        $sql = "SELECT * FROM grupeoShops.text WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $textId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $dataTextId = self::fetch($queryResource);

        return self::create($dataTextId);

    }

    /**
     * @param \models\shops\Text $text
     * @return int
     * @throws \Exception
     */
    public static function insertText($text) {

        $sql = "INSERT INTO grupeoShops.text (name,titleHome,metaHome,metaAbout,metaFAQ,metaPolicies)"
            . "VALUES ('%s','%s','%s','%s','%s','%s')";

        $sprintfSql = sprintf($sql,
            $text->getName(),
            $text->getTitleHome(),
            $text->getMetaHome(),
            $text->getMetaAbout(),
            $text->getMetaFAQ(),
            $text->getMetaPolicies()
            );

        try {
            $lastInsertedId = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastInsertedId;

    }

    /**
     * @param \models\shops\Text $text
     * @return bool
     * @throws \Exception
     */
    public static function updateText($text) {

        $sql = "UPDATE grupeoShops.text"
            . " SET name= '%s', titleHome = '%s', metaHome = '%s', metaAbout = '%s',"
            . " metaFAQ = '%s', metaPolicies = '%s'"
            . " WHERE id = '%s'";

        $sprintfSql = sprintf($sql,
            $text->getName(),
            $text->getTitleHome(),
            $text->getMetaHome(),
            $text->getMetaAbout(),
            $text->getMetaFAQ(),
            $text->getMetaPolicies(),
            $text->getId()
        );

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;

    }

    /**
     * @param int $textId
     * @return bool
     * @throws \Exception
     */
    public static function deleteTextById($textId) {

        $sql = "DELETE FROM grupeoShops.text WHERE id = '%s'";

        $sprintfSql = sprintf($sql, $textId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isDeleted;

    }
}
