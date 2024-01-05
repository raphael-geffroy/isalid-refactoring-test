<?php

declare(strict_types=1);

namespace AppTest\Service;

use App\Context\ApplicationContext;
use App\Entity\User;
use App\Service\UserFirstnameTemplateProcessor;
use App\ValueObject\TemplatedText;
use PHPUnit\Framework\TestCase;

class UserFirstnameTemplateProcessorTest extends TestCase
{
    public function testItReplacesPlaceholderWithConnectedUser(): void
    {
        $applicationContextStub = new class extends ApplicationContext {
            public function getCurrentUser()
            {
                return new User(1, 'Tryphon', 'Tournesol', 'tryphon.tournesol@gmail.com');
            }

        };
        $processor = new UserFirstnameTemplateProcessor($applicationContextStub);
        $templatedText = new TemplatedText('Hello [user:first_name]');

        $processor->process($templatedText, []);

        $this->assertEquals('Hello Tryphon',$templatedText);
    }

    public function testItReplacesPlaceholderWithContextUser(): void
    {
        $processor = new UserFirstnameTemplateProcessor(new ApplicationContext());
        $templatedText = new TemplatedText('Hello [user:first_name]');

        $processor->process($templatedText, [
            'user' => new User(1, 'Archibald', 'Haddock', 'tryphon.tournesol@gmail.com')
        ]);

        $this->assertEquals('Hello Archibald',$templatedText);
    }
}
