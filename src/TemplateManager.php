<?php

declare(strict_types=1);

namespace App;

use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\Template;
use App\Entity\User;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;

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
    private function computeText(string $text, array $data): string
    {
        $quote = $data['quote'] ?? null;

        if ($quote instanceof Quote) {
            $site = $this->siteRepository->getById($quote->siteId);
            $destination = $this->destinationRepository->getById($quote->destinationId);

            if (str_contains($text, '[quote:summary_html]')) {
                $text = str_replace('[quote:summary_html]', Quote::renderHtml($quote), $text);
            }
            if (str_contains($text, '[quote:summary]')) {
                $text = str_replace('[quote:summary]', Quote::renderText($quote), $text);
            }

            if (str_contains($text, '[quote:destination_name]')) {
                $text = str_replace('[quote:destination_name]', $destination->countryName, $text);
            }

            if (str_contains($text, '[quote:destination_link]')) {
                $link = sprintf('%s/%s/quote/%d', $site->url, $destination->countryName, $quote->id);
                $text = str_replace('[quote:destination_link]', $link, $text);
            }
        }

        if(str_contains($text, '[quote:destination_link]')){
            $text = str_replace('[quote:destination_link]', '', $text);
        }

        $user = $data['user'] ?? null;
        if(!$user instanceof User){
            $user = $this->applicationContext->getCurrentUser();
        }

        if(str_contains($text, '[user:first_name]')) {
            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->firstname)), $text);
        }

        return $text;
    }
}
