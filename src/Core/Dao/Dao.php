<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 24/09/12
 * Time: 20:00
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Dao;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

final class Dao
{
    /** Private constructor. This class cannot be instantiated. */
    private function __construct()
    {
    }

    public static function getConnection($connection = 'default')
    {
        try {
            $yaml = new Parser();
            //TODO: mettre dans Memcache ou APC pour eviter la lecture de fichier à répétition.
            $connectionParams = $yaml->parse(
                file_get_contents(dirname(__FILE__) . '/../../../init/parameters.yml')
            );

            return DriverManager::getConnection($connectionParams[$connection], new Configuration());

        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
    }
}