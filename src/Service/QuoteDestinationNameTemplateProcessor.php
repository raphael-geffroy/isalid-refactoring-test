<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Quote;
use App\Repository\DestinationRepository;
use App\ValueObject\TemplatedText;

readonly class QuoteDestinationNameTemplateProcessor implements TemplateProcessorInterface
{
    public function __construct(
        private DestinationRepository $destinationRepository,
    )
    {
    }

    /**
     * @param array{
     *     quote: Quote
     * } $context
     */
    public function process(TemplatedText $text, array $context): void
    {
        $quote = $context['quote'];
        $destination = $this->destinationRepository->getById($quote->destinationId);
        $text->replaceAll('[quote:destination_name]', $destination->countryName);
    }

    public function supports(TemplatedText $text, array $context): bool
    {
        return $text->contains('[quote:destination_name]')
            && ($context['quote'] ?? null) instanceof Quote;
    }
}
