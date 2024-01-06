<?php

declare(strict_types=1);

namespace App;

use App\Entity\Quote;
use App\Entity\Template;
use App\Entity\User;
use App\Service\TemplateProcessorInterface;

readonly class TemplateManager
{
    public function __construct(
        private TemplateProcessorInterface $templateProcessor,
    ) {
    }

    /**
     * @param array{
     *     quote ?: Quote,
     *     user ?: User,
     * } $data
     */
    public function getTemplateComputed(Template $tpl, array $data): Template
    {
        $this->templateProcessor->process($tpl->subject, $data);
        $this->templateProcessor->process($tpl->content, $data);

        return $tpl;
    }
}
