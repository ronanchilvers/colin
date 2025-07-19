<?php

declare(strict_types=1);

namespace App\Actions;

use App\ActionInterface;
use App\Actions\Traits\TemplateAction;

class Board implements ActionInterface
{
    use TemplateAction;
}
