<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\TemplatedText;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

#[AsAlias(TemplateProcessorInterface::class)]
readonly class ChainTemplateProcessor implements TemplateProcessorInterface
{
    /**
     * @param iterable<TemplateProcessorInterface> $processors
     */
    public function __construct(
        #[AutowireIterator(TemplateProcessorInterface::class, exclude: self::class)] private iterable $processors
    ){
    }

    public function process(TemplatedText $text, array $context): void
    {
        foreach ($this->processors as $processor){
            if($processor->supports($text, $context)){
                $processor->process($text, $context);
            }
        }
    }

    public function supports(TemplatedText $text, array $context): bool
    {
        foreach ($this->processors as $processor) {
            if ($processor->supports($text, $context)) {

                return true;
            }
        }

        return false;
    }
}
