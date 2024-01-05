<?php

declare(strict_types=1);

namespace App\Entity;

readonly class Destination
{
    public function __construct(
        public int $id,
        public string $countryName,
        public string $conjunction,
        public string $computerName
    ){
    }
}
