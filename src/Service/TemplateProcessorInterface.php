<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Quote;
use App\Entity\User;
use App\ValueObject\TemplatedText;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(TemplateProcessorInterface::class)]
interface TemplateProcessorInterface
{
    /**
     * @param array{
     *     quote ?: Quote,
     *     user ?: User,
     * } $context
     */
    public function process(TemplatedText $text, array $context): void;

    /**
     * @param array{
     *     quote ?: Quote,
     *     user ?: User,
     * } $context
     */
    public function supports(TemplatedText $text, array $context): bool;
}
