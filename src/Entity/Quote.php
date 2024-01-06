<?php

declare(strict_types=1);

namespace App\Entity;

readonly class Quote
{
    public function __construct(
        public int $id,
        public int $siteId,
        public int $destinationId,
        public string|\DateTimeInterface $dateQuoted
    ) {
    }

    public static function renderHtml(Quote $quote): string
    {
        return '<p>' . $quote->id . '</p>';
    }

    public static function renderText(Quote $quote): string
    {
        return (string) $quote->id;
    }
}
