<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 28/09/12
 * Time: 17:24
 * To change this template use File | Settings | File Templates.
 */

namespace Core\DAO\Repository;

use Core\DAO\Dao;
use Core\Mongo\Mongo;
use Core\Pdo\Pdo;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class Repository
 * @package Core\DAO\Repository
 */
class Repository
{
    /**
     * @return QueryBuilder
     */
    public function getQuery($connection='default')
    {
        return new QueryBuilder(Dao::getConnection($connection));
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getDb($connection = 'default')
    {
        return Dao::getConnection($connection);
    }

    /**
     * @return \MongoClient
     */
    public function getMongo()
    {
        return Mongo::getConnection();
    }

    /**
     * @return \Pdo
     */
    public function getPdo($connection = 'default')
    {
        return Pdo::getConnection($connection);
    }
}