<?php

namespace daos\internal\tool;

class AdminDAO extends \daos\internal\bases\SqlDAO {

    public static function create($data = null){
        return new \models\tool\Admin($data);
    }

    /**
     * @param Int $adminId
     * @return \models\tool\Admin
     * @throws \Exception
     */
    public static function getAdminById($adminId) {
        $sql = "SELECT * FROM grupeoTools.admin WHERE id = '%d'";

        $sprintfSql = sprintf($sql, $adminId);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param Int $shopId
     * @param String $email
     * @return \models\tool\Admin
     * @throws \Exception
     */
    public static function getAdminByShopIdAndEmail($shopId,$email) {
        $sql = "SELECT * FROM grupeoTools.admin WHERE shopId = '%d' AND email = '%s'";

        $sprintfSql = sprintf($sql, $shopId, $email);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     * @param String $email
     * @return \models\tool\Admin
     * @throws \Exception
     */
    public static function getAdminByEmail($email) {
        $sql = "SELECT * FROM grupeoTools.admin WHERE email = '%s'";

        $sprintfSql = sprintf($sql, $email);

        try {
            $queryResource = self::select($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        $data = self::fetch($queryResource);

        return static::create($data);
    }

    /**
     *
     * @param String $email
     * @param String $plainPassword
     * @return \models\tool\Admin
     */
    static function getAdminByEmailPassword($email, $plainPassword) {
        $admin = self::getAdminByEmail($email);
        if ($admin && \Password::validatePassword($plainPassword, $admin->getSalt(), $admin->getPassword())) {
            return $admin;
        }
        return null;
    }

    /**
     * @param \models\tool\Admin $admin
     * @return int
     * @throws \Exception
     */
    public static function insertAdmin(\models\tool\Admin $admin) {
        $sql = "INSERT grupeoTools.admin (shopId,email,password,salt,home,allowedControllers,activated)"
            . " VALUES ('%d','%s','%s','%s','%s','%s','%d')";

        $sprintfSql = sprintf($sql,
            $admin->getShopId(),
            $admin->getEmail(),
            $admin->getPassword(),
            $admin->getSalt(),
            $admin->getHome(),
            $admin->getAllowedControllers(),
            $admin->getActivated());

        try {
            $lastIdInserted = self::insert($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $lastIdInserted;
    }

    /**
     * @param \models\tool\Admin $admin
     * @return bool
     * @throws \Exception
     */
    public static function updateAdmin(\models\tool\Admin $admin) {
        $sql = "UPDATE grupeoTools.admin"
            . " SET shopId = '%d', email = '%s', password = '%s', salt = '%s', home = '%s', allowedControllers = '%s', activated = '%s'"
            . " WHERE id = '%d'";

        $sprintfSql = sprintf($sql,
            $admin->getShopId(),
            $admin->getEmail(),
            $admin->getPassword(),
            $admin->getSalt(),
            $admin->getHome(),
            $admin->getAllowedControllers(),
            $admin->getActivated(),
            $admin->getId());

        try {
            $isUpdated = self::update($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }

        return $isUpdated;
    }

    /**
     * @param Int $adminId
     * @return bool
     * @throws \Exception
     */
    public static function deleteAdminById($adminId) {
        $sql = "DELETE FROM grupeoTools.admin WHERE id='%d'";

        $sprintfSql = sprintf($sql, $adminId);

        try {
            $isDeleted = self::delete($sprintfSql);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), ERROR_503);
        }
        return $isDeleted;
    }

}
