<?php

declare(strict_types=1);

namespace Sylius\TwigHooks\Hookable\Renderer\Debug;

use Sylius\TwigHooks\Hookable\AbstractHookable;
use Sylius\TwigHooks\Hookable\Metadata\HookableMetadata;
use Sylius\TwigHooks\Hookable\Renderer\HookableRendererInterface;

final class HookableDebugCommentRenderer implements HookableRendererInterface
{
    public function __construct(private readonly HookableRendererInterface $innerRenderer)
    {
    }

    public function render(AbstractHookable $hookable, HookableMetadata $metadata): string
    {
        $renderedParts = [];
        $renderedParts[] = $this->getOpeningDebugComment($hookable);
        $renderedParts[] = trim($this->innerRenderer->render($hookable, $metadata));
        $renderedParts[] = $this->getClosingDebugComment($hookable);

        return implode(PHP_EOL, $renderedParts);
    }

    private function getOpeningDebugComment(AbstractHookable $hookable): string
    {
        return sprintf(
            '<!-- BEGIN HOOKABLE | hook: "%s", type: "%s", name: "%s", target: "%s", priority: %d -->',
            $hookable->hookName,
            $hookable->getType(),
            $hookable->name,
            $hookable->target,
            $hookable->getPriority(),
        );
    }

    private function getClosingDebugComment(AbstractHookable $hookable): string
    {
        return sprintf(
            '<!--  END HOOKABLE  | hook: "%s", type: "%s", name: "%s", target: "%s", priority: %d -->',
            $hookable->hookName,
            $hookable->getType(),
            $hookable->name,
            $hookable->target,
            $hookable->getPriority(),
        );
    }
}
