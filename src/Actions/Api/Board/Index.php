<?php

declare(strict_types=1);

namespace App\Actions\Api\Board;

use Flight;
use Ramsey\Uuid\Uuid;

class Index
{
    public function __invoke(string $id)
    {
        if (!Uuid::isValid($id)) {
            Flight::jsonHalt([
                'ok' => false,
                'error' => 'Invalid board id'
            ]);
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
                "Todo",
                "In Progress",
                "Done",
            ],
            "board" => [
                "Todo" => $cards,
                "In Progress" => $cards,
                "Done" => $cards,
            ]
        ];

        // Emit JSON
        Flight::json($data);
    }
}
