<?php

namespace daos\internal\bases;

class SqlDAO {

    public static function select($sql) {
        $result = \DbConnector::getInstance()->query($sql);
        if (!$result) {
            _logErr("Error in select query::" . $sql);
            throw new \Exception('Error en Select Query' . $sql,ERROR_503);
        }
        return $result;
    }

    public static function insert($sql) {
        if (!\DbConnector::getInstance()->query($sql)) {
            _logErr("Error in insert query::" . $sql);
            throw new \Exception('Error en Insert Query',ERROR_503);
        }
        return \DbConnector::getInstance()->getLastGenerateId();
    }

    public static function update($sql) {
        if (!\DbConnector::getInstance()->query($sql)) {
            _logErr("Error in update query::" . $sql);
            throw new \Exception('Error en Update Query',ERROR_503);
        }
        return true;
    }

    public static function delete($sql) {
        if (!\DbConnector::getInstance()->query($sql)) {
            _logErr("Error in delete query::" . $sql);
            throw new \Exception('Error en Delete Query',ERROR_503);
        }
        return true;
    }

    public static function fetch($queryResource) {
        return \DbConnector::getInstance()->fetch($queryResource);
    }

    public static function fetchAll($queryResource) {
        return \DbConnector::getInstance()->fetchAll($queryResource);
    }

}
