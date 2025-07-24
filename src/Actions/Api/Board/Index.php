<?php

declare(strict_types=1);

namespace App\Actions\Api\Board;

use Flight;
use Ramsey\Uuid\Uuid;
use App\Actions\Api\Response;
use App\Actions\Traits\HasConnection;
use Exception;
use PDOException;

class Index
{
    use HasConnection;

    public function __invoke(string $id)
    {
        $response = new Response();
        try {
            $board = Flight::get('board');
            $columns = $this->connection()->select(
                "SELECT *
                 FROM columns
                 WHERE column_board = :board_id
                 ORDER BY column_position",
                ['board_id' => $board['board_id']]
            );
            $cards = $this->connection()->select(
                "SELECT *
                FROM columns, cards
                WHERE card_column = column_id
                    AND column_board = card_board
                    AND card_board = :board_id
                ORDER BY column_position",
                ['board_id' => $board['board_id']]
            );

            $data = [
                'board'   => [
                    'id' => $board['board_uuid'],
                    'title' => $board['board_title'],
                ],
                'columns' => [],
                'cards'   => [],
            ];
            foreach ($columns as $column) {
                $data['columns'][] = [
                    'id' => $column['column_uuid'],
                    'title' => $column['column_title'],
                ];
            }
            foreach ($cards as $card) {
                if (!isset($data['cards'][$card['column_uuid']])) {
                    $data['cards'][$card['column_uuid']] = [];
                }
                $data['cards'][$card['column_uuid']][] = [
                    'id' => $card['card_uuid'],
                    'title' => $card['card_title'],
                    'content' => $card['card_content'],
                ];
            }

            // Emit JSON
            Flight::jsonHalt(
                $response->withPayload(
                    'board',
                    $data
                )->toArray()
            );
        } catch (Exception $ex) {
            $response->withError('Internal error', Response::CODE_ERROR);
        }
        Flight::jsonHalt(
            $response
                ->toArray()
        );
    }
}
