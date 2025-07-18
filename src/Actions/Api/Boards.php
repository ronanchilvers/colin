<?php

declare(strict_types=1);

namespace App\Actions\Api;

use App\ActionInterface;
use App\Template\Factory;
use Flight;

class Boards implements ActionInterface
{
    public function __invoke()
    {
        $data = [
            'columns' => [
                "Todo",
                "In Progress",
                "Done",
            ],
            "board" => [
                "Todo" => [
                    [
                        'id' => 1,
                        'title' => "Card number 1",
                        'content' => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudiandae rem error illo, nulla quod voluptatum necessitatibus molestiae. In, esse iure quae sit, magni delectus repellendus est odio, dignissimos odit eius."
                    ],
                    [
                        'id' => 2,
                        'title' => "Card number 2",
                        'content' => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudiandae rem error illo, nulla quod voluptatum necessitatibus molestiae. In, esse iure quae sit, magni delectus repellendus est odio, dignissimos odit eius."
                    ],
                ],
                "In Progress" => [
                    [
                        'id' => 3,
                        'title' => "Card number 3",
                        'content' => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repudiandae rem error illo, nulla quod voluptatum necessitatibus molestiae. In, esse iure quae sit, magni delectus repellendus est odio, dignissimos odit eius."
                    ],
                ],
                "Done" => [],
            ]
        ];

        Flight::json($data);
    }
}
