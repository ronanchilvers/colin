<?php

declare(strict_types=1);

namespace App\Actions\Api\Column;

use Flight;
use Ramsey\Uuid\Uuid;
use App\Actions\Api\Response;
use Exception;
use App\Actions\Traits\HasConnection;

class Order
{
    use HasConnection;

    public function __invoke($board)
    {
        $response = new Response();
        try {
            $data = Flight::request()->data;
            if (empty($data) || !isset($data['order'])) {
                Flight::jsonHalt(
                    $response
                        ->withError("Column data is invalid")
                        ->toArray()
                );
            }
            $board = Flight::get('board');
            $orderedColumns = '"' . implode('", "', $data['order']) . '"';
            $this
                ->connection()
                ->query('SET @i = 0');
            $this
                ->connection()
                ->query(
                    "UPDATE columns SET column_position = (@i := @i + 1)
                    WHERE
                        column_board = :board
                        AND column_uuid IN ({$orderedColumns})
                    ORDER BY FIELD(column_uuid, {$orderedColumns})",
                    ['board' => $board['board_id']]
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
