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

$routes = [
    // Frontend
    'GET /' => new \App\Actions\Index(),
    'GET /board/@id' => new \App\Actions\Board(),

    // Board API
    'GET /api/board/@id' => new \App\Actions\Api\Board\Index(),
    'POST /api/board' => new \App\Actions\Api\Board\Create(),

    // Card API
    // 'GET /api/card/@id' => new \App\Actions\Api\Card\Index(),
    'POST /api/card/@id' => new \App\Actions\Api\Card\Update(),
];
foreach ($routes as $endpoint => $action) {
    Flight::route(
        $endpoint,
        $action
    );
}
// Flight::route(
//     "/api/board",
//     new \App\Actions\Api\Board\Index()
// );
// Flight::route(
//     "/api/board",
//     new \App\Actions\Api\Board\Index()
// );

Flight::start();
