<?php

declare(strict_types=1);

namespace Wwwision\Neos\ModuleComponents\Eel;

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\ActionRequest;
use Neos\Flow\Mvc\Routing\UriBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

#[Flow\Scope('singleton')]
final class ModuleLinkHelper implements ProtectedContextAwareInterface
{

    /**
     * @param ActionRequest $request
     * @param string $module
     * @param string $action
     * @param array $arguments
     * @param bool $addQueryString
     * @return string
     */
    public function create(ActionRequest $request, string $module, string $action, array $arguments, bool $addQueryString): string
    {
        $uriBuilder = new UriBuilder();
        $uriBuilder->setRequest($request->getMainRequest());

        $arguments = [
            'module' => $module,
            'moduleArguments' => array_merge($arguments, ['@action' => $action]),
        ];
        return $uriBuilder->uriFor('index', $arguments);
    }

    public function allowsCallOfMethod($methodName): bool
    {
        return true;
    }
}
