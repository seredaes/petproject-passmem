<?php

namespace App\Response;

class GlobalResponse implements GlobalResponseInterface
{
    protected array $data = [];

    public function success(): static
    {
        $this->data["status"] = "success";
        return $this;
    }

    public function error(): static
    {
        $this->data["status"] = "error";
        return $this;
    }

    public function setMessage(string $message): static
    {
        $this->data["message"] = $message;
        return $this;
    }

    public function setData(array $data): static
    {
        $this->data["data"] = $data;
        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
