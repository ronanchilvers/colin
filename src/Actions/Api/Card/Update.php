<?php

declare(strict_types=1);

namespace App\Actions\Api\Card;

use Flight;
use Ramsey\Uuid\Uuid;
use App\Actions\Api\Response;
use Exception;
use App\Actions\Traits\HasConnection;

class Update
{
    use HasConnection;

    public function __invoke(string $board, string $id)
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
            if ($data->id !== $id) {
                Flight::jsonHalt(
                    $response
                        ->withError("Card data is invalid", Response::CODE_ID_MISMATCH)
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
            $this->connection()->update(
                'cards',
                [
                    'card_column' => $column['column_id'],
                    'card_title' => $data['title'],
                    'card_content' => $data['content'],
                ],
                "card_uuid = :card_uuid AND card_board = :card_board",
                [
                    'card_uuid' => $data['id'],
                    'card_board' => $board['board_id'],
                ]
            );

            Flight::jsonHalt(
                $response
                    ->withPayload(
                        'card',
                        [
                            'id' => $id,
                        ]
                    )
                    ->toArray()
            );
        } catch (Exception $ex) {
            Flight::jsonHalt(
                $response
                    ->withError($ex->getMessage())
                    ->toArray()
            );
        }
    }
}
