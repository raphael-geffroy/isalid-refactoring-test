<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Quote;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use App\ValueObject\TemplatedText;

readonly class QuoteDestinationLinkTemplateProcessor implements TemplateProcessorInterface
{
    public function __construct(
        private SiteRepository $siteRepository,
        private DestinationRepository $destinationRepository,
    ) {
    }

    public function process(TemplatedText $text, array $context): void
    {
        $quote = $context['quote'] ?? null;

        if ($quote instanceof Quote) {
            $site = $this->siteRepository->getById($quote->siteId);
            $destination = $this->destinationRepository->getById($quote->destinationId);
            $link = sprintf('%s/%s/quote/%d', $site->url, $destination->countryName, $quote->id);
            $text->replaceAll('[quote:destination_link]', $link);

            return;
        }

        $text->replaceAll('[quote:destination_link]', '');
    }

    public function supports(TemplatedText $text, array $context): bool
    {
        return $text->contains('[quote:destination_link]');
    }
}
