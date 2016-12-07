<?php

namespace daos\external\shops;

class TextDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\shops\Text($data);
    }

    /**
     * @param int $textId
     * @return \models\shops\Text
     */
    public static function getTextById($textId) {
        $response = self::execute(URL_SERVER_SHOPS.'/text/getById','getById',[$textId]);
        return \models\shops\Text::undoSerialize($response);
    }

    /**
     * @param \models\shops\Text $text
     * @return int
     */
    public static function insertText($text) {
        $response = self::execute(URL_SERVER_SHOPS.'/text/insert','insert',[serialize($text)]);
        return unserialize($response);
    }

    /**
     * @param \\models\shopsText $text
     * @return bool
     */
    public static function updateText($text) {
        $response = self::execute(URL_SERVER_SHOPS.'/text/update','update',[serialize($text)]);
        return unserialize($response);
    }

    /**
     * @param int $textId
     * @return bool
     * @throws \Exception
     */
    public static function deleteTextById($textId) {
        $response = self::execute(URL_SERVER_SHOPS.'/text/deleteById','deleteById',[$textId]);
        return unserialize($response);
    }

}
