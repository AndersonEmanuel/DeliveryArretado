<?php

/**
 * Enabled display errors
 */
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

/**
 * This makes our life easier when dealing with paths. Everything is relative to the application root now.
 */
chdir(dirname(__DIR__));

/**
 * Decline static file requests back to the PHP built-in webserver
 */
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url(filter_input(INPUT_SERVER, 'REQUEST_URI'), PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

require __DIR__ . '/../vendor/autoload.php';

/**
 * session_start();
 */
$app = new Silex\Application();

require __DIR__ . '/../public/services.php';

require __DIR__ . '/../public/providers.php';

require __DIR__ . '/../public/middleware.php';

require __DIR__ . '/../public/routes.php';

$app->run();
