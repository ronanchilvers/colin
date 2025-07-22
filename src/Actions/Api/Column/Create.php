<?php

declare(strict_types=1);

namespace App\Actions\Api\Column;

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
                    ->withError("Column data is invalid")
                    ->toArray()
            );
        }
        $label = $data->label;

        Flight::json(
            $response->withPayload(
                'column', [
                    'id' => Uuid::uuid7(),
                    'label' => $label,
                ]
            )->toArray()
        );
    }
}
