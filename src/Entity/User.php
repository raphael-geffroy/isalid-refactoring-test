<?php

declare(strict_types=1);

namespace App\Entity;

readonly class User
{
    public function __construct(
        public int $id,
        public string $firstname,
        public string $lastname,
        public string $email
    ){
    }
}
