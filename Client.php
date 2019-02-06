<?php
/**
 * Created by PhpStorm.
 * User: vasyl
 * Date: 06.02.19
 * Time: 20:13
 */

namespace MongoTest;

/**
 * Class Client
 * @package MongoTest
 */
class Client
{
    private static $instance = null;

    /**
     * @return \MongoDB\Driver\Manager
     * @throws \MongoConnectionException
     */
    public static function getInstance():\MongoDB\Driver\Manager
    {

        if (self::$instance === null) {
            self::$instance = new \MongoDB\Driver\Manager('mongodb://' . Config::HOST . ':' . Config::PORT);
            return self::$instance;
        }

        return self::$instance;
    }


    private function __construct()
    {
    }

    private function __clone()
    {
    }


}