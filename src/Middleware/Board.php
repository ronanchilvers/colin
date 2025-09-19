<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Actions\Api\Response;
use App\Actions\Traits\HasConnection;
use Ramsey\Uuid\Uuid;
use Flight;
use Exception;

class Board
{
    use HasConnection;

    /**
     * @return void
     * @param mixed $params
     */
    public function before($params): void
    {
        if (isset($params['board']) && Uuid::isValid($params['board'])) {
            try {
                $board = $this->connection()->selectOne(
                    "SELECT * FROM boards WHERE board_uuid = :board_uuid",
                    ['board_uuid' => $params['board']]
                );
                if (is_array($board)) {
                    Flight::set('board', $board);
                }
            } catch (Exception $ex) {
                Flight::jsonHalt(
                    (new Response())
                        ->withError('Board not found')
                        ->toArray(),
                    404
                );
            }
        }
    }
}
