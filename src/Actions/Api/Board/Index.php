<?php

declare(strict_types=1);

namespace App\Actions\Api\Board;

use Flight;
use Ramsey\Uuid\Uuid;
use App\Actions\Api\Response;

class Index
{
    public function __invoke(string $id)
    {
        $response = new Response();
        if (!Uuid::isValid($id)) {
            Flight::jsonHalt(
                $response
                    ->withError('Invalid board id')
                    ->toArray()
            );
        }
        $cards = [];
        for ($i = 1; $i < 3; $i++)
        {
            $cards[] = [
                'id' => Uuid::uuid7(),
                'title' => "Card number {$i}",
                'content' => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudiandae rem error illo, nulla quod voluptatum necessitatibus molestiae. In, esse iure quae sit, magni delectus repellendus est odio, dignissimos odit eius."
            ];
        }

        $data = [
            'columns' => [
                ["id" => "col1", "label" => "Todo"],
                ["id" => "col2", "label" => "In Progress"],
                ["id" => "col3", "label" => "Done"],
            ],
            "board" => [
                "col1" => $cards,
                "col2" => $cards,
                "col3" => $cards,
            ]
        ];

        // Emit JSON
        Flight::json(
            $response->withPayload(
                'board',
                $data
            )->toArray()
        );
    }
}
