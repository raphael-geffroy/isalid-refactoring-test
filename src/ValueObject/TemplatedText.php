<?php

declare(strict_types=1);

namespace App\ValueObject;

class TemplatedText implements \Stringable
{
    public function __construct(
        private string $text,
    ) {
    }

    public function replaceAll(string $placeholder, string $value): void
    {
        $this->text = str_replace($placeholder, $value, $this->text);
    }

    public function contains(string $needle): bool
    {
        return str_contains($this->text, $needle);
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
