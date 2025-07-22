<?php

declare(strict_types=1);

namespace App\Actions\Api\Card;

use Flight;
use Ramsey\Uuid\Uuid;
use App\Actions\Api\Response;

class Delete
{
    public function __invoke(string $id)
    {
        $response = new Response();
        $data = Flight::request()->data;
        if (!Uuid::isValid($id) || empty($data)) {
            Flight::jsonHalt(
                $response
                    ->withError("Card data is invalid")
                    ->toArray()
            );
        }

        $id = $data->id;

        Flight::json($response->toArray());
    }
}
