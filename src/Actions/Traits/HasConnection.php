<?php

declare(strict_types=1);

namespace App\Actions\Traits;

use App\Database\Connection;

trait HasConnection
{
    public function __construct(
        private Connection $connection
    ) {
    }

    protected function connection()
    {
        return $this->connection;
    }
}
