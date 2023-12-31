<?php

declare(strict_types=1);

namespace Wwwision\Neos\ModuleComponents\Eel;

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\I18n\Service;
use Neos\Flow\I18n\Translator;
use Neos\Flow\Mvc\ActionRequest;

#[Flow\Scope('singleton')]
final class I18nHelper implements ProtectedContextAwareInterface
{

    public function __construct(
        private readonly Translator $translator,
        private readonly Service $i18nService,
    ) {
    }

    public function translateById(ActionRequest $actionRequest, string $id, array $arguments = [], int $quantity = null, string $source = 'Modules'): ?string
    {
        return $this->translator->translateById($id, $arguments, $quantity, null, $source, $actionRequest->getControllerPackageKey());
    }

    public function translateContent(ActionRequest $actionRequest, string $content, string $source = 'Modules'): string
    {
        return preg_replace_callback('/LLL:(?<json>{[^}]+}|(?<id>[a-z][a-zA-Z0-9\.\-\_]+))/', fn (array $match) => $this->translateById($actionRequest, $match['id'], isset($match['quantity']) ? [$match['quantity']] : [], isset($match['quantity']) ? (int)$match['quantity'] : null, $source) ?? '[' . $match['id'] . ']', $content);
    }

    public function locale(): string
    {
        return (string)$this->i18nService->getConfiguration()->getCurrentLocale();
    }

    public function allowsCallOfMethod($methodName): bool
    {
        return true;
    }
}
