<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\TemplatedText;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(TemplateProcessorInterface::class)]
interface TemplateProcessorInterface
{
    public function process(TemplatedText $text, array $context): void;
    public function supports(TemplatedText $text, array $context): bool;
}
