<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\TemplatedText;

readonly class Template
{
    public function __construct(
        public int    $id,
        public TemplatedText $subject,
        public TemplatedText $content,
    ) {
    }
}
