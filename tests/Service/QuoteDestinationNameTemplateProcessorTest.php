<?php

declare(strict_types=1);

namespace AppTest\Service;

use App\Entity\Destination;
use App\Entity\Quote;
use App\Repository\DestinationRepository;
use App\Service\QuoteDestinationNameTemplateProcessor;
use App\ValueObject\TemplatedText;
use PHPUnit\Framework\TestCase;

class QuoteDestinationNameTemplateProcessorTest extends TestCase
{
    public function testItReplacesPlaceholderWithConnectedUser(): void
    {
        $destinationRepositoryStub = new class extends DestinationRepository {
            public function getById($id)
            {
                return new Destination(1, 'France', 'conjuction', 'computerName');
            }

        };
        $processor = new QuoteDestinationNameTemplateProcessor($destinationRepositoryStub);
        $templatedText = new TemplatedText('Destination [quote:destination_name]');

        $processor->process($templatedText, ['quote' => new Quote(1,1,1,'date')]);

        $this->assertEquals('Destination France',$templatedText);
    }
}
