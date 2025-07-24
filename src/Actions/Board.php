<?php

declare(strict_types=1);

namespace App\Actions;

use App\Actions\Traits\TemplateAction;
use Ramsey\Uuid\Uuid;
use App\Template\Factory;
use Flight;
use App\Database\Board as DbBoard;
use App\Actions\Traits\HasConnection;

class Board
{
    use TemplateAction,
        HasConnection;

    public function __invoke(string $id)
    {
        if (!Uuid::isValid($id)) {
            Flight::redirect('/', 302);
        }

        $template = Factory::make('board.html');
        echo $template->render();
    }
}
