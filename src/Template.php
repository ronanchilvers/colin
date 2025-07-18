<?php

declare(strict_types=1);

namespace App;

use Exception;

class Template
{
    private string $template;
    private array $data = [];
    public function __construct(
        string $template
    ) {
        if (!file_exists($template)) {
            throw new Exception("no such template : {$template}");
        }
        $this->template = $template;
    }

    public function clear(): static
    {
        $this->data = [];

        return $this;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function __get(string $name): mixed
    {
        $lower = strtolower($name);
        $uc = ucfirst($lower);
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        if (array_key_exists($lower, $this->data)) {
            return $this->data[$lower];
        }
        if (array_key_exists($uc, $this->data)) {
            return $this->data[$uc];
        }

        return null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }

    public function set(string $name, mixed $value): static
    {
        $this->__set($name, $value);

        return $this;
    }

    public function render(): string
    {
        ob_start();
        include $this->template;
        return ob_get_clean();
    }

    public function renderFile($filename)
    {
        return file_put_contents(
            $filename,
            $this->render()
        );
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
