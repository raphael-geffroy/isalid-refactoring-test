<?php

use App\Entity\Quote;
use App\Entity\Template;
use App\Kernel;
use App\TemplateManager;
use App\ValueObject\TemplatedText;
use Faker\Factory;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new Kernel();
$kernel->boot();
$container = $kernel->getContainer();

$faker = Factory::create();

$template = new Template(
    1,
    new TemplatedText('Votre livraison à [quote:destination_name]'),
    new TemplatedText("
Bonjour [user:first_name],

Merci de nous avoir contacté pour votre livraison à [quote:destination_name].

Bien cordialement,

L'équipe de Shipper
"));
$templateManager = $container->get(TemplateManager::class);

$message = $templateManager->getTemplateComputed(
    $template,
    [
        'quote' => new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date())
    ]
);

echo $message->subject . "\n" . $message->content;
