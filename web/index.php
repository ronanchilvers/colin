<?php

declare(strict_types=1);

require_once(__DIR__ . '/../vendor/autoload.php');

use App\Template\Factory;

Factory::setBaseDir(__DIR__ . '/../templates');

Flight::route(
    "/",
    new \App\Actions\Index()
);

Flight::route(
    "/api/board",
    new \App\Actions\Api\Boards()
);

Flight::start();
