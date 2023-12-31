<?php

declare(strict_types=1);

namespace Wwwision\Neos\ModuleComponents\Eel;

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

#[Flow\Scope('singleton')]
final class PaginationHelper implements ProtectedContextAwareInterface
{
    /**
     * @param array{numberOfResults: int, resultsPerPage: int, queryParameter: string} $options
     * @param ServerRequestInterface $httpRequest
     * @return array<int, array{label: string, type: "previous"|"default"|"current"|"ellipsis"|"next", href?:UriInterface}>
     */
    public function create(array $options, ServerRequestInterface $httpRequest): array
    {
        $numberOfPages = (int)ceil($options['numberOfResults'] / $options['resultsPerPage']);
        $queryParameter = $options['queryParameter'];
        $currentPageNumber = isset($httpRequest->getQueryParams()[$queryParameter]) ? (int)$httpRequest->getQueryParams()[$queryParameter] : 1;
        if ($currentPageNumber > $numberOfPages || $currentPageNumber < 1) {
            $currentPageNumber = 1;
        }

        $maximumNumberOfLinks = 5;
        if ($maximumNumberOfLinks > $numberOfPages) {
            $maximumNumberOfLinks = $numberOfPages;
        }
        $delta = floor($maximumNumberOfLinks / 2);
        $displayRangeStart = $currentPageNumber - $delta;
        $displayRangeEnd = $currentPageNumber + $delta + ($maximumNumberOfLinks % 2 === 0 ? 1 : 0);
        if ($displayRangeStart < 1) {
            $displayRangeEnd -= $displayRangeStart - 1;
        }
        if ($displayRangeEnd > $numberOfPages) {
            $displayRangeStart -= ($displayRangeEnd - $numberOfPages);
        }
        $displayRangeStart = (int)max($displayRangeStart, 1);
        $displayRangeEnd = (int)min($displayRangeEnd, $numberOfPages);
        if ($displayRangeStart === $displayRangeEnd) {
            return [];
        }

        $links = [];
        if ($currentPageNumber > 1) {
            $links[] = [
                'label' => 'previous',
                'type' => 'previous',
                'href' => $this->paginationUri($httpRequest, $queryParameter, $currentPageNumber - 1),
            ];
        }
        if ($displayRangeStart > 1) {
            $links[] = [
                'label' => '1',
                'href' => $this->paginationUri($httpRequest, $queryParameter, 1),
                'type' => 'default',
            ];
            if ($displayRangeStart > 2) {
                $links[] = [
                    'label' => '...',
                    'type' => 'ellipsis',
                ];
            }
        }
        for ($pageNumber = $displayRangeStart; $pageNumber <= $displayRangeEnd; $pageNumber++) {
            $links[] = [
                'label' => (string)$pageNumber,
                'href' => $this->paginationUri($httpRequest, $queryParameter, $pageNumber),
                'type' => $pageNumber === $currentPageNumber ? 'current' : 'default',
            ];
        }
        if ($displayRangeEnd < $numberOfPages) {
            if ($displayRangeEnd < ($numberOfPages - 1)) {
                $links[] = [
                    'label' => '...',
                    'type' => 'ellipsis',
                ];
            }
            $links[] = [
                'label' => (string)$numberOfPages,
                'href' => $this->paginationUri($httpRequest, $queryParameter, $numberOfPages),
                'type' => 'default',
            ];
        }
        if ($currentPageNumber < $numberOfPages) {
            $links[] = [
                'label' => 'next',
                'type' => 'next',
                'href' => $this->paginationUri($httpRequest, $queryParameter, $currentPageNumber + 1),
            ];
        }
        return $links;
    }

    private function paginationUri(ServerRequestInterface $request, string $queryParameter, int $pageNumber): UriInterface
    {
        $queryParams = $request->getQueryParams();
        if ($pageNumber > 1) {
            $queryParams[$queryParameter] = $pageNumber;
        } else {
            unset($queryParams[$queryParameter]);
        }
        return $request->getUri()->withQuery(http_build_query($queryParams));
    }

    public function allowsCallOfMethod($methodName): bool
    {
        return true;
    }
}
