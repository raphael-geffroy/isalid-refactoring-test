<?php

declare(strict_types=1);

namespace AppTest;

use App\Context\ApplicationContext;
use App\Entity\Quote;
use App\Entity\Template;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use App\TemplateManager;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class TemplateManagerTest extends TestCase
{
    private SiteRepository $siteRepository;
    private DestinationRepository $destinationRepository;
    private ApplicationContext $applicationContext;

    /**
     * Init the mocks
     */
    public function setUp(): void
    {
        $this->siteRepository = new SiteRepository();
        $this->destinationRepository = new DestinationRepository();
        $this->applicationContext = new ApplicationContext();
    }

    /**
     * Closes the mocks
     */
    public function tearDown(): void
    {
    }

    /**
     * @test
     */
    public function test()
    {
        $faker = Factory::create();

        $destinationId                  = $faker->randomNumber();
        $expectedDestination = $this->destinationRepository->getById($destinationId);
        $expectedUser        = $this->applicationContext->getCurrentUser();

        $quote = new Quote($faker->randomNumber(), $faker->randomNumber(), $destinationId, $faker->date());

        $template = new Template(
            1,
            'Votre livraison à [quote:destination_name]',
            "
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

Bien cordialement,

L'équipe de Shipper
");
        $templateManager = new TemplateManager(
            $this->siteRepository,
            $this->destinationRepository,
            $this->applicationContext
        );

        $message = $templateManager->getTemplateComputed(
            $template,
            [
                'quote' => $quote
            ]
        );

        $this->assertEquals('Votre livraison à ' . $expectedDestination->countryName, $message->subject);
        $this->assertEquals("
Bonjour " . $expectedUser->firstname . ",

Merci de nous avoir contacté pour votre livraison à " . $expectedDestination->countryName . ".

Bien cordialement,

L'équipe de Shipper
", $message->content);
    }
}
