<?php

declare(strict_types=1);

namespace App\Actions\Api\Card;

use Flight;
use Ramsey\Uuid\Uuid;
use App\Actions\Api\Response;
use App\Actions\Traits\HasConnection;
use Exception;

class Create
{
    use HasConnection;

    public function __invoke()
    {
        $response = new Response();
        try {
            $data = Flight::request()->data;
            if (empty($data)) {
                Flight::jsonHalt(
                    $response
                        ->withError("Card data is invalid")
                        ->toArray()
                );
            }
            $column = Uuid::fromString($data['column']);
            $column = $this->connection()->selectOne(
                "SELECT * FROM columns
                WHERE column_uuid = :column",
                [
                    'column' => $data['column'],
                ]
            );
            if (empty($column)) {
                Flight::jsonHalt(
                    $response
                        ->withError('Invalid column')
                        ->toArray()
                );
            }
            $board = Flight::get('board');
            $uuid = Uuid::uuid7();
            $this->connection()->insert(
                'cards',
                [
                    'card_uuid' => $uuid,
                    'card_board' => $board['board_id'],
                    'card_column' => $column['column_id'],
                    'card_title' => $data['title'],
                    'card_content' => $data['content'],
                ]
            );

            Flight::json(
                $response->withPayload(
                    'card', [
                        'id' => $uuid,
                    ]
                )->toArray()
            );
        } catch (Exception $ex) {
            Flight::jsonHalt(
                $response
                    // ->withError('Internal error')
                    ->withError($ex->getMessage())
                    ->toArray()
            );
        }
    }
}
