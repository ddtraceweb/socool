<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 05/05/13
 * Time: 21:31
 * To change this template use File | Settings | File Templates.
 */


namespace Core\Pdo;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class Pdo
{

    public static function getConnection($connection = 'default')
    {
        try {
            $yaml = new Parser();
            //TODO: mettre dans Memcache ou APC pour eviter la lecture de fichier à répétition.
            $connectionParams = $yaml->parse(
                file_get_contents(dirname(__FILE__) . '/../../../init/parameters.yml')
            );

            $dsn              = 'mysql:dbname=' . $connectionParams[$connection]['dbname'] . ';host=' . $connectionParams[$connection]['host'];

            $pdo = new \Pdo($dsn, $connectionParams[$connection]['user'], $connectionParams[$connection]['password']);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
    }
}