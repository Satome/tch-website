<?php

//Init autoloader
if(null == 'ROOT_PATH') {
    define('ROOT_PATH', dirname(__DIR__));
}

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    include($_SERVER['DOCUMENT_ROOT'] . '/' . $class . '.php');
});

// Set the encoding
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

?>