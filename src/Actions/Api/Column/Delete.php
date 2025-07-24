<?php

declare(strict_types=1);

namespace App\Actions\Api\Column;

use Flight;
use Ramsey\Uuid\Uuid;
use App\Actions\Api\Response;
use Exception;
use App\Actions\Traits\HasConnection;

class Delete
{
    use HasConnection;

    public function __invoke($board, $column)
    {
        $response = new Response();
        try {
            $uuid = Uuid::fromString($column);
            $board = Flight::get('board');
            $where = "column_board = :column_board and column_uuid = :column_uuid";
            $records = [
                'column_uuid' => $uuid->toString(),
                'column_board' => $board['board_id'],
            ];
            $this
                ->connection()
                ->delete(
                    'columns',
                    $where,
                    $records
                );

            Flight::jsonHalt(
                $response->toArray()
            );
        } catch (Exception $ex) {
            Flight::jsonHalt(
                $response
                    ->withError($ex->getMessage())
                    // ->withError('Internal error')
                    ->toArray()
            );
        }
    }
}
