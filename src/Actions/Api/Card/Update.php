<?php

declare(strict_types=1);

namespace App\Actions\Api\Card;

use Flight;
use Ramsey\Uuid\Uuid;

class Update
{
    public function __invoke()
    {
        $response = [
            'ok' => true,
            'error' => null,
            'board' => []
        ];
        $name = Flight::request()->data;
        if (empty($data)) {
            $response['ok'] = false;
            $response['error'] = "Card data is invalid";
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
