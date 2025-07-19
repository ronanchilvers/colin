<?php

declare(strict_types=1);

namespace App\Actions\Traits;

use App\Template\Factory;
use Exception;

trait TemplateAction
{
    public function __invoke()
    {
        $template = Factory::make(
            $this->getTemplateName()
        );

        echo $template->render();
    }

    protected function getTemplateName()
    {
        $templateName = str_replace('App\\Actions\\', '', static::class);
        $templateName = strtolower($templateName) . '.html';
        if (!Factory::exists($templateName)) {
            throw new Exception('Unable to find template ' . $templateName);
        }

        return $templateName;
    }
}
