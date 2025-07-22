<?php

declare(strict_types=1);

namespace App\Actions\Api;

class Response
{
    const CODE_OK = 0;
    const CODE_ID_INVALID = 100;
    const CODE_ID_MISMATCH = 101;
    const CODE_INVALID_DATA = 102;

    protected $ok = true;
    protected $error = false;
    protected $code = null;

    protected $data = [];

    public function __construct()
    {
        $this->code = static::CODE_OK;
    }

    public function withOk(bool $bool): static
    {
        $this->ok = $bool;

        return $this;
    }

    public function withError(string $error, ?int $code = null): static
    {
        $this->ok = false;
        $this->error = $error;
        $this->code = $code ?? static::CODE_INVALID_DATA;

        return $this;
    }

    public function withPayload(string $name, array $data): static
    {
        $this->data[$name] = $data;

        return $this;
    }

    public function toArray()
    {
        $array = [
            'ok' => $this->ok,
            'error' => $this->error,
            'code' => $this->code,
        ];

        return array_merge($array, $this->data);
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }
}
