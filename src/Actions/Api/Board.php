<?php

declare(strict_types=1);

namespace App\Actions\Api;

use App\ActionInterface;
use App\Template\Factory;
use Flight;

class Board implements ActionInterface
{
    public function __invoke()
    {
        $cards = [];
        for ($i = 1; $i < 10; $i++)
        {
            $cards[] = [
                'id' => $i,
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
