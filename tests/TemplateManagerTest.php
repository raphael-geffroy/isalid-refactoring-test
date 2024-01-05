<?php

declare(strict_types=1);

namespace AppTest;

use App\Entity\Template;
use App\Service\TemplateProcessorInterface;
use App\TemplateManager;
use App\ValueObject\TemplatedText;
use PHPUnit\Framework\TestCase;

class TemplateManagerTest extends TestCase
{
    public function test()
    {
        $templateProcessorSpy = new class implements TemplateProcessorInterface {
            /**
             * @var array<array{text: TemplatedText, context: array<string, mixed>}>
             */
            private array $processorProcessCallsParams = [];

            public function process(TemplatedText $text, array $context): void
            {
                $this->processorProcessCallsParams[] = [
                    'text' => $text,
                    'context' => $context
                ];
            }

            public function supports(TemplatedText $text, array $context): bool
            {
                return true;
            }

            public function getProcessorProcessCallsParams(): array
            {
                return $this->processorProcessCallsParams;
            }
        };

        $templateManager = new TemplateManager($templateProcessorSpy);

        $template = new Template(1, $a = new TemplatedText('A'), $b = new TemplatedText('B'));

        $templateManager->getTemplateComputed($template, $context = ['a' => 1]);

        $this->assertEquals([
            ['text' => $a, 'context' => $context],
            ['text' => $b, 'context' => $context],
        ],$templateProcessorSpy->getProcessorProcessCallsParams());

    }
}
