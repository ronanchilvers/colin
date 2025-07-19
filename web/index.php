<?php

declare(strict_types=1);

require_once(__DIR__ . '/../vendor/autoload.php');

use App\Template\Factory;

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

Factory::setBaseDir(__DIR__ . '/../templates');

Flight::route(
    "/",
    new \App\Actions\Index()
);
Flight::route(
    "/board",
    new \App\Actions\Board()
);

Flight::route(
    "/api/board",
    new \App\Actions\Api\Board()
);

Flight::start();
