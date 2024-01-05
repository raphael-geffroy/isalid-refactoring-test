<?php

declare(strict_types=1);

namespace App\Entity;

readonly class Site
{
    public function __construct(
        public int $id,
        public string $url
    ){
    }
}
