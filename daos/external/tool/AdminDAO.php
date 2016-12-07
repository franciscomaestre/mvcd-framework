<?php

namespace daos\external\tool;

class AdminDAO extends \daos\external\bases\JsonRpcClientDAO {

    public static function create($data = null){
        return new \models\tool\Admin($data);
    }

    /**
     * @param Int $adminId
     * @return \models\tool\Admin
     */
    public static function getAdminById($adminId) {
        $response = self::execute(URL_SERVER_TOOL.'/admin/getLineById','getLineById',[$adminId]);
        return \models\tool\Admin::undoSerialize($response);
    }

    /**
     * @param Int $shopId
     * @param String $email
     * @return \models\tool\Admin
     */
    public static function getAdminByShopIdAndEmail($shopId,$email) {
        $response = self::execute(URL_SERVER_TOOL.'/admin/getByShopIdAndEmail','getByShopIdAndEmail',[$shopId,$email]);
        return \models\tool\Admin::undoSerialize($response);
    }

    /**
     * @param String $email
     * @return \models\tool\Admin
     */
    public static function getAdminByEmail($email) {
        $response = self::execute(URL_SERVER_TOOL.'/admin/getByEmail','getByEmail',[$email]);
        return \models\tool\Admin::undoSerialize($response);
    }

    /**
     * @param \models\tool\Admin $admin
     * @return Int
     */
    public static function insertAdmin(\models\tool\Admin $admin) {
        $response = self::execute(URL_SERVER_TOOL.'/admin/insertLine','insertLine',[serialize($admin)]);
        return unserialize($response);
    }

    /**
     * @param \models\tool\Admin $admin
     * @return bool
     */
    public static function updateAdmin(\models\tool\Admin $admin) {
        $response = self::execute(URL_SERVER_TOOL.'/admin/updateLine','updateLine',[serialize($admin)]);
        return unserialize($response);
    }

    /**
     * @param Int $adminId
     * @return bool
     */
    public static function deleteAdminById($adminId) {
        $response = self::execute(URL_SERVER_TOOL.'/admin/deleteLineById','deleteLineById',[$adminId]);
        return unserialize($response);
    }
}
