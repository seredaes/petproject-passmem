<?php

namespace App\DTO;

class ListDTO
{

    /**
     * @param string $title
     * @param string $login
     * @param string $password
     * @param string $description
     */
    public function __construct(
        public readonly string $title,
        public readonly string $login,
        public readonly string $password,
        public readonly string $description,
        public readonly string $user_id
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "login" => $this->login,
            "password" => $this->password,
            "description" => $this->description,
            "user_id" => $this->user_id
        ];
    }
}
