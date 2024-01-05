<?php

declare(strict_types=1);

namespace AppTest\Service;

use App\Entity\Quote;
use App\Service\QuoteSummaryTemplateProcessor;
use App\ValueObject\TemplatedText;
use PHPUnit\Framework\TestCase;

class QuoteSummaryTemplateProcessorTest extends TestCase
{
    public function testItReplacesPlaceholderWithConnectedUser(): void
    {
        $processor = new QuoteSummaryTemplateProcessor();
        $templatedText = new TemplatedText('Summary [quote:summary]');

        $processor->process($templatedText, ['quote' => new Quote(1,1,1,'date')]);

        $this->assertEquals('Summary 1',$templatedText);
    }
}
