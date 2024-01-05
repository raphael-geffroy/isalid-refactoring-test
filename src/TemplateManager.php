<?php

declare(strict_types=1);

namespace App;

use App\Entity\Template;
use App\Service\TemplateProcessorInterface;

readonly class TemplateManager
{
    public function __construct(
        private TemplateProcessorInterface $templateProcessor,
    )
    {
    }

    public function getTemplateComputed(Template $tpl, array $data): Template
    {
        $this->templateProcessor->process($tpl->subject, $data);
        $this->templateProcessor->process($tpl->content, $data);

        return $tpl;
    }
}
