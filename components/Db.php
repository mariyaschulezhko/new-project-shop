<?php


namespace components;

/**
 * Class Db
 * @package components
 */
class Db
{

    /**
     * @return \PDO
     */
    public static function getConnection()
    {
        $db_param = require __DIR__ . '/../config/db_params.php';

        $db = new \PDO("mysql:host={$db_param['host']};dbname={$db_param['dbname']}", $db_param['user'], $db_param['password']);

        return $db;


    }

}