<?php

namespace App\Service;

use App\Context\ApplicationContext;
use App\Entity\User;
use App\ValueObject\TemplatedText;

readonly class UserFirstnameTemplateProcessor implements TemplateProcessorInterface
{
    public function __construct(
        private ApplicationContext $applicationContext,
    ) {
    }

    public function process(TemplatedText $text, array $context): void
    {
        $user = $context['user'] ?? null;
        if (!$user instanceof User) {
            $user = $this->applicationContext->getCurrentUser();
        }

        if ($text->contains('[user:first_name]')) {
            $text->replaceAll('[user:first_name]', $user->getFormattedFirstname());
        }
    }

    public function supports(TemplatedText $text, array $context): bool
    {
        return $text->contains('[user:first_name]');
    }
}
