<?php

declare(strict_types=1);

namespace Wwwision\Neos\ModuleComponents\Eel;

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Error\Messages\Message;
use Neos\Flow\Mvc\ActionRequest;
use Neos\Flow\Mvc\Exception\InvalidFlashMessageConfigurationException;
use Neos\Flow\Mvc\FlashMessage\FlashMessageService;
use Neos\Flow\Security\Exception\InvalidRequestPatternException;
use Neos\Flow\Security\Exception\NoRequestPatternFoundException;
use Neos\Flow\Annotations as Flow;

#[Flow\Scope('singleton')]
final class FlashMessageHelper implements ProtectedContextAwareInterface
{

    public function __construct(
        private readonly FlashMessageService $flashMessageService,
    ) {
    }

    /**
     * Whether there are any messages in the FlashMessageContainer
     *
     * @param ActionRequest $request The currently active ActionRequest
     * @return bool
     */
    public function hasMessages(ActionRequest $request): bool
    {
        try {
            return $this->flashMessageService->getFlashMessageContainerForRequest($request)->hasMessages();
        } catch (InvalidFlashMessageConfigurationException | InvalidRequestPatternException | NoRequestPatternFoundException $e) {
            return false;
        }
    }

    /**
     * Returns all currently stored flash messages.
     * @see \Neos\Flow\Mvc\FlashMessage\FlashMessageContainer::getMessages()
     *
     * @param ActionRequest $request The currently active ActionRequest
     * @param string|null $severity If set, only messages matching the specified severity are returned (allowed values: "Notice", "Warning", "Error", "OK")
     * @return Message[]
     */
    public function getMessages(ActionRequest $request, string $severity = null): array
    {
        try {
            return $this->flashMessageService->getFlashMessageContainerForRequest($request)->getMessages($severity);
        } catch (InvalidFlashMessageConfigurationException | InvalidRequestPatternException | NoRequestPatternFoundException $e) {
            return [];
        }
    }

    /**
     * Get all flash messages (with given severity) currently available and remove them from the container.
     * @see \Neos\Flow\Mvc\FlashMessage\FlashMessageContainer::getMessagesAndFlush()
     *
     * @param ActionRequest $request The currently active ActionRequest
     * @param string|null $severity If set, only messages matching the specified severity are returned (allowed values: "Notice", "Warning", "Error", "OK")
     * @return Message[]
     */
    public function getMessagesAndFlush(ActionRequest $request, string $severity = null): array
    {
        try {
            return $this->flashMessageService->getFlashMessageContainerForRequest($request)->getMessagesAndFlush($severity);
        } catch (InvalidFlashMessageConfigurationException | InvalidRequestPatternException | NoRequestPatternFoundException $e) {
            return [];
        }
    }

    public function allowsCallOfMethod($methodName): bool
    {
        return true;
    }
}
