<?php

declare(strict_types=1);

namespace App\Actions\Api\Card;

use Flight;
use Ramsey\Uuid\Uuid;
use App\Actions\Api\Response;

class Create
{
    public function __invoke()
    {
        $response = new Response();
        $data = Flight::request()->data;
        if (empty($data)) {
            Flight::jsonHalt(
                $response
                    ->withError("Card data is invalid")
                    ->toArray()
            );
        }

        Flight::json(
            $response->withPayload(
                'card', [
                 'id' => Uuid::uuid7()
                ]
            )->toArray()
        );
    }
}
