<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Quote;
use App\ValueObject\TemplatedText;

readonly class QuoteSummaryHtmlTemplateProcessor implements TemplateProcessorInterface
{
    /**
     * @param array{
     *     quote: Quote
     * } $context
     */
    public function process(TemplatedText $text, array $context): void
    {
        $quote = $context['quote'];
        $text->replaceAll('[quote:summary_html]', Quote::renderHtml($quote));
    }

    public function supports(TemplatedText $text, array $context): bool
    {
        return $text->contains('[quote:summary_html]')
            && ($context['quote'] ?? null) instanceof Quote;
    }
}
