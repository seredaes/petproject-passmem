<?php

namespace App\DTO;

class UserAuthDTO
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $access_token
     */
    public function __construct(
        public readonly string $email,
        public readonly  string $password,
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
          "email" => $this->email,
          "password" => $this->password,
        ];
    }
}
