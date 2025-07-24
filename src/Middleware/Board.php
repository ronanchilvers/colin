<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Actions\Traits\HasConnection;
use Ramsey\Uuid\Uuid;
use Flight;
use Exception;

class Board
{
    use HasConnection;

    public function before($params)
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

            }
        }
    }
}
