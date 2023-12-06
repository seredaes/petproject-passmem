<?php

namespace App\DTO;

class UserRegisterDTO
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $access_token
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly  string $password,
        public readonly string $access_token
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
          "name" => $this->name,
          "email" => $this->email,
          "password" => $this->password,
          "access_token" => $this->access_token
        ];
    }
}
