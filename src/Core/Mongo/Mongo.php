<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 26/03/13
 * Time: 19:37
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Mongo;

class Mongo{

    public static function getConnection()
    {
        $mongoClient = new \MongoClient();

        return $mongoClient;
    }
}