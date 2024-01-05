<?php

declare(strict_types=1);

namespace App\Entity;

readonly class Template
{
    public function __construct(
        public int    $id,
        public string $subject,
        public string $content,
    )
    {
    }
}
