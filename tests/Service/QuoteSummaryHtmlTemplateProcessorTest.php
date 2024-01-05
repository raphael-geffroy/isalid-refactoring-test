<?php

declare(strict_types=1);

namespace AppTest\Service;

use App\Entity\Quote;
use App\Service\QuoteSummaryHtmlTemplateProcessor;
use App\ValueObject\TemplatedText;
use PHPUnit\Framework\TestCase;

class QuoteSummaryHtmlTemplateProcessorTest extends TestCase
{
    public function testItReplacesPlaceholderWithConnectedUser(): void
    {
        $processor = new QuoteSummaryHtmlTemplateProcessor();
        $templatedText = new TemplatedText('Summary [quote:summary_html]');

        $processor->process($templatedText, ['quote' => new Quote(1,1,1,'date')]);

        $this->assertEquals('Summary <p>1</p>',$templatedText);
    }
}
