<?php

declare(strict_types=1);

namespace App\Actions;

use App\Actions\Traits\TemplateAction;
use Ramsey\Uuid\Uuid;
use App\Template\Factory;
use Flight;
use App\Actions\Traits\HasConnection;

class Board
{
    use TemplateAction;
    use HasConnection;

    /**
     * @return void
     */
    public function __invoke(string $id): void
    {
        if (!Uuid::isValid($id)) {
            Flight::redirect('/', 302);
        }

        $template = Factory::make('board.html.php');
        echo $template->render();
    }
}
