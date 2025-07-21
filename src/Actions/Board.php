<?php

declare(strict_types=1);

namespace App\Actions;

use App\Actions\Traits\TemplateAction;
use Ramsey\Uuid\Uuid;
use App\Template\Factory;

class Board
{
    use TemplateAction;

    public function __invoke(string $id)
    {
        if (!Uuid::isValid($id)) {
            Flight::redirect('/', 302);
        }
        $template = Factory::make('board.html');
        echo $template->render();
    }
}
