<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Quote;
use App\ValueObject\TemplatedText;

readonly class QuoteSummaryTemplateProcessor implements TemplateProcessorInterface
{
    /**
     * @param array{
     *     quote: Quote
     * } $context
     */
    public function process(TemplatedText $text, array $context): void
    {
        $quote = $context['quote'];
        $text->replaceAll('[quote:summary]', Quote::renderText($quote));
    }

    public function supports(TemplatedText $text, array $context): bool
    {
        return $text->contains('[quote:summary]')
            && ($context['quote'] ?? null) instanceof Quote;
    }
}
