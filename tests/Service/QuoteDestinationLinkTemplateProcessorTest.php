<?php

declare(strict_types=1);

namespace AppTest\Service;

use App\Entity\Destination;
use App\Entity\Quote;
use App\Entity\Site;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use App\Service\QuoteDestinationLinkTemplateProcessor;
use App\ValueObject\TemplatedText;
use PHPUnit\Framework\TestCase;

class QuoteDestinationLinkTemplateProcessorTest extends TestCase
{
    public function testItReplacesPlaceholderWithConnectedUser(): void
    {
        $siteRepositoryStub = new class extends SiteRepository {
            public function getById($id)
            {
                return new Site(1, 'https://url.com');
            }

        };
        $destinationRepositoryStub = new class extends DestinationRepository {
            public function getById($id)
            {
                return new Destination(1, 'France', 'conjuction', 'computerName');
            }

        };
        $processor = new QuoteDestinationLinkTemplateProcessor($siteRepositoryStub, $destinationRepositoryStub);
        $templatedText = new TemplatedText('Site [quote:destination_link]');

        $processor->process($templatedText, ['quote' => new Quote(1,1,1,'date')]);

        $this->assertEquals('Site https://url.com/France/quote/1',$templatedText);
    }
}
