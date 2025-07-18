<?php

declare(strict_types=1);

namespace App\Actions;

use App\ActionInterface;
use App\Template\Factory;

class Index implements ActionInterface
{
    public function __invoke()
    {
        $template = Factory::make('index.html');

        echo $template->render();
    }
}
