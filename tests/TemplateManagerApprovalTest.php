<?php

declare(strict_types=1);

namespace AppTest;

use App\Entity\Quote;
use App\Entity\Template;
use App\Entity\User;
use App\TemplateManager;
use ApprovalTests\CombinationApprovals;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TemplateManagerApprovalTest extends TestCase
{
    const QUOTE_ID = 1;
    const QUOTE_DATE = '2023-01-01T08:00:00Z';

    const SITE_ID = 2;
    const DESTINATION_ID = 3;
    const USER_ID = 4;

    const TEMPLATE_ID = 5;
    const TEMPLATE_SUBJECT = 'Votre livraison à [quote:destination_name]';
    const TEMPLATE_CONTENT = <<<EOT
Bla [user:first_name]
blabla [quote:destination_name]
blablabla [quote:destination_link]
blablablabla [quote:summary_html]
blablablablabla [quote:summary]
EOT;

    public function test()
    {
        CombinationApprovals::verifyAllCombinations3(
            [$this, 'callTemplateManagerWithParams'],
            [self::TEMPLATE_CONTENT],
            [true, false],
            [true, false]
        );
    }

    public function callTemplateManagerWithParams($content, $withQuote, $withUser)
    {
        $templateManager = new TemplateManager();

        $context = [];
        if ($withQuote) {
            $quote = new Quote(
                self::QUOTE_ID,
                self::SITE_ID,
                self::DESTINATION_ID,
                new DateTimeImmutable(self::QUOTE_DATE)
            );
            $context['quote'] = $quote;
        }
        if ($withUser) {
            $user = new User(self::USER_ID, 'Tryphon', 'Tournesol', 'tryphon.tournesol@gmail.com');
            $context['user'] = $user;
        }

        $template = new Template(self::TEMPLATE_ID, self::TEMPLATE_SUBJECT, $content);

        $result = $templateManager->getTemplateComputed($template, $context);

        /*
         * We need to scrub the result because when we do not provide a user
         * it takes it from the ApplicationContext which is an unseeded faked value
         */
        return $this->scrub(
            $this->printTemplate($result),
            '/(?<=Bla )[a-zA-Z]+/',
            'FIRSTNAME_'
        );
    }

    /**
     * @param Template $template
     * @return string
     */
    private function printTemplate($template)
    {
        return sprintf('{"id": "%s","subject": "%s","content": "%s"}', $template->id, $template->subject, $template->content);
    }

    /**
     * @param string $text
     * @param string $regex
     * @param string $prefix
     * @return string
     */
    private function scrub($text, $regex, $prefix)
    {
        preg_match_all($regex, $text, $matches);
        $matching = $matches[0];

        $matchingToId = array_flip(array_unique($matching));

        $replacedByValue = array_map(function ($id) use ($prefix){
            return $prefix . $id;
        }, $matchingToId);

        return str_replace(array_keys($replacedByValue), $replacedByValue, $text);
    }
}
