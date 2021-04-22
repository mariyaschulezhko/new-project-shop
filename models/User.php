<?php


namespace models;


use components\Db;

/**
 * Class User
 * @package models
 */
class User
{
    /**
     * @param $name
     * @param $email
     * @param $password
     * @return bool
     */
    public static function register($name, $email, $password) {
        $db = Db::getConnection();
        $sql = "INSERT INTO user (name, email, password) VALUE (:name, :email, :password)";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name,\PDO::PARAM_STR);
        $result->bindParam(':email', $email,\PDO::PARAM_STR);
        $result->bindParam(':password', $password,\PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * @param $name
     * @return bool
     */
    public static function checkName($name) {
        if (strlen($name) > 2) {
            return true;
        }
        return false;
    }

    /**
     * @param $password
     * @return bool
     */
    public static function checkPassword($password) {
        if (strlen($password) >= 6){
            return true;
        }
    }


    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * @param $email
     * @return bool
     */
    public static function checkEmailExists($email) {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, \PDO::PARAM_STR);
        $result->execute();

        if($result->fetchColumn())
            return true;
        return false;

    }

    /**
     * @param $email
     * @param $password
     * @return false|mixed
     */
    public static function checkUserDate($email, $password) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, \PDO::PARAM_STR);
        $result->bindParam(':password', $password, \PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch();
        if($user) {
            return $user['id'];
        }
        return false;
    }

    /**
     * @param $userId
     */
    public static function auth($userId) {

        $_SESSION['user'] = $userId;
    }

    public static function checkLogged()
    {

        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header("Location: /user/login");
    }


    /**
     * @return bool
     */
    public static function isGuest() {

        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function getUserById($userId) {
        if ($userId) {
            $db = Db::getConnection();

            $sql = 'SELECT * FROM user WHERE id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(':id', $userId, \PDO::PARAM_INT);
            $result->setFetchMode(\PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();

        }
    }

    /**
     * @param $userId
     * @param $name
     * @param $password
     * @return bool
     */
    public static function edit($userId, $name, $password) {
        $db = Db::getConnection();
        $sql = 'UPDATE user SET name = :name,  password = :password WHERE id = :userId';
        $result = $db->prepare($sql);
        $result->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $result->bindParam(':name', $name, \PDO::PARAM_STR);
        $result->bindParam(':password', $password, \PDO::PARAM_STR);
        return $result->execute();

    }

    /**
     * @param $phone
     * @return bool
     */
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }


}