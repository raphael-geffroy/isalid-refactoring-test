<?php

declare(strict_types=1);

namespace App;

use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\Template;
use App\Entity\User;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use App\ValueObject\TemplatedText;

readonly class TemplateManager
{
    public function __construct(
        private SiteRepository        $siteRepository,
        private DestinationRepository $destinationRepository,
        private ApplicationContext    $applicationContext,
    )
    {
    }

    public function getTemplateComputed(Template $tpl, array $data): Template
    {
        return new Template(
            $tpl->id,
            $this->computeText($tpl->subject, $data),
            $this->computeText($tpl->content, $data)
        );
    }

    /**
     * @param array{
     *     quote?: Quote,
     *     user?: User,
     * } $data
     */
    private function computeText(TemplatedText $text, array $data): TemplatedText
    {
        $quote = $data['quote'] ?? null;

        $user = $data['user'] ?? null;
        if (!$user instanceof User) {
            $user = $this->applicationContext->getCurrentUser();
        }

        if ($quote instanceof Quote) {
            $site = $this->siteRepository->getById($quote->siteId);
            $destination = $this->destinationRepository->getById($quote->destinationId);

            if ($text->contains('[quote:summary_html]')) {
                $text->replaceAll('[quote:summary_html]', Quote::renderHtml($quote));
            }
            if ($text->contains('[quote:summary]')) {
                $text->replaceAll('[quote:summary]', Quote::renderText($quote));
            }

            if ($text->contains('[quote:destination_name]')) {
                $text->replaceAll('[quote:destination_name]', $destination->countryName);
            }

            if ($text->contains('[quote:destination_link]')) {
                $link = sprintf('%s/%s/quote/%d', $site->url, $destination->countryName, $quote->id);
                $text->replaceAll('[quote:destination_link]', $link);
            }
        }

        if ($text->contains('[quote:destination_link]')) {
            $text->replaceAll('[quote:destination_link]', '');
        }

        if ($text->contains('[user:first_name]')) {
            $text->replaceAll('[user:first_name]', $user->getFormattedFirstname());
        }

        return $text;
    }
}
