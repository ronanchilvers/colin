<?php

declare(strict_types=1);

namespace App\Actions\Api\Board;

use App\Actions\Api\Response;
use App\Actions\Traits\HasConnection;
use Exception;
use Flight;
use Ramsey\Uuid\Uuid;

class Create
{
    use HasConnection;

    /**
     * @return void
     */
    public function __invoke(): void
    {
        $response = new Response();
        try {
            $title = Flight::request()->data->title;
            if (empty($title)) {
                Flight::jsonHalt(
                    $response
                        ->withError("Empty titles aren't allowed")
                        ->toArray()
                );
            }
            $uuid = Uuid::uuid7();
            $this->connection()->insert(
                'boards',
                [
                    'board_uuid' => $uuid,
                    'board_title' => $title,
                ]
            );

            $response->withPayload(
                'board',
                [
                    'id' => $uuid,
                    'title' => $title,
                ]
            );

            Flight::jsonHalt($response->toArray());
        } catch (Exception $ex) {
            Flight::jsonHalt(
                $response
                    ->withError('Internal error')
                    ->toArray()
            );
        }
    }
}
