<?php

declare(strict_types=1);

namespace App\Actions\Api\Board;

use Flight;
use Ramsey\Uuid\Uuid;

class Create
{
    public function __invoke()
    {
        $response = [
            'ok' => true,
            'error' => null,
            'board' => []
        ];
        $name = Flight::request()->data->name;
        if (empty($name)) {
            $response['ok'] = false;
            $response['error'] = "Empty names aren't allowed";
            Flight::jsonHalt($response);
        }

        $response = [
            'ok' => true,
            'board' => [
                'id' => Uuid::uuid7(),
                'name' => $name,
            ]
        ];

        Flight::json($response);
    }
}
