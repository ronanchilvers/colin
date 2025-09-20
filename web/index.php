<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Template\Factory;
use flight\Container;

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

$config = include_once __DIR__ . '/../config/config.php';
Factory::setBaseDir(__DIR__ . '/../templates');

$container = new Container();
require_once __DIR__ . '/../config/services.php';

Flight::registerContainerHandler([$container, 'get']);

Flight::route('GET /', [ \App\Actions\Index::class , '__invoke' ]);

Flight::route('GET /board/@board', [\App\Actions\Board::class, '__invoke']);

Flight::route(
    'POST /api/board',
    [ \App\Actions\Api\Board\Create::class , '__invoke' ]
);

Flight::group(
    '',
    function () {
        Flight::route(
            'GET /api/board/@board',
            [ \App\Actions\Api\Board\Index::class , '__invoke' ]
        );
        // Flight::route('PUT ',
        //     [ \App\Actions\Api\Board\Update::class , '__invoke' ]
        // );

        Flight::route(
            'POST /api/board/@board/column',
            [ \App\Actions\Api\Column\Create::class , '__invoke' ]
        );
        Flight::route(
            'DELETE /api/board/@board/column/@column',
            [ \App\Actions\Api\Column\Delete::class , '__invoke' ]
        );
        // Flight::route(
        //     'PUT /api/board/@board/column/order',
        //     [ \App\Actions\Api\Column\Order::class , '__invoke' ]
        // );

        // Flight::route(
        //     'GET /api/board/@board/card/@card',
        //     [ \App\Actions\Api\Card\Index::class , '__invoke' ]
        // );
        // Flight::route(
        //     'POST /api/board/@board/card',
        //     [ \App\Actions\Api\Card\Create::class , '__invoke' ]
        // );
        // Flight::route(
        //     'PUT /api/board/@board/card/@card',
        //     [ \App\Actions\Api\Card\Update::class , '__invoke' ]
        // );
        // Flight::route(
        //     'DELETE /api/board/@board/card/@card',
        //     [ \App\Actions\Api\Card\Delete::class , '__invoke' ]
        // );
    },
    [
        \App\Middleware\Board::class,
    ]
);

// $boardRoutes = [
//     // Frontend
//     'GET /' =>  [ \App\Actions\Index::class , '__invoke' ],
//     'GET /board/@uuid' => [\App\Actions\Board::class, '__invoke'],

//     // Board API
//     'POST /api/board' =>  [ \App\Actions\Api\Board\Create::class , '__invoke' ],
//     'GET /api/board/@uuid' =>  [ \App\Actions\Api\Board\Index::class , '__invoke' ],
//     // 'PUT /api/board/@uuid' =>  [ \App\Actions\Api\Board\Update::class , '__invoke' ],

//     // Colummn API
//     'POST /api/board/@uuid/column' =>  [ \App\Actions\Api\Column\Create::class , '__invoke' ],

//     // Card API
//     // 'GET /api/card/@id' =>  [ \App\Actions\Api\Card\Index::class , '__invoke' ],
//     'POST /api/card' =>  [ \App\Actions\Api\Card\Create::class , '__invoke' ],
//     'PUT /api/card/@uuid' =>  [ \App\Actions\Api\Card\Update::class , '__invoke' ],
//     'DELETE /api/card/@uuid' =>  [ \App\Actions\Api\Card\Delete::class , '__invoke' ],
// ];
// foreach ($routes as $endpoint => $action) {
//     Flight::route(
//         $endpoint,
//         $action
//     );
// }

Flight::start();
