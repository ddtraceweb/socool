<?php

define('WEBROOT', __DIR__);
define('MUNEE_CACHE', dirname(__FILE__).'/../init/cache');

// Include the composer autoload file
require dirname(__FILE__) . '/../vendor/autoload.php';
// Echo out the response
echo \Munee\Dispatcher::run(
    new \Munee\Request(array(
        'image'      => array(
            'numberOfAllowedFilters' => 100,
            'imageProcessor'         => 'GD'
        ),
    ))
);