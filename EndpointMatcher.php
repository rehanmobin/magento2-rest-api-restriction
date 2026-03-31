<?php

namespace Mage4\RestApiRestriction\Model;

final class EndpointMatcher
{
    public function isBlocked(string $requestPath, array $blockedEndpoints): bool
    {
        $requestPath = $this->normalizePath($requestPath);
        foreach ($blockedEndpoints as $endpoint) {
            $regex = $this->convertIntoRegex($this->normalizePath($endpoint));
            if (\preg_match($regex, $requestPath) === 1) {
                return true;
            }
        }
        return false;
    }

    private function convertIntoRegex(string $template): string
    {
        $segments = \explode('/', trim($template, '/'));
        $regexParts = [];
        foreach ($segments as $segment) {
            if (str_starts_with($segment, ':')) {
                $regexParts[] = '[^/]+';
                continue;
            }
            $regexParts[] = preg_quote($segment, '#');
        }
        return '#^/' . implode('/', $regexParts) . '$#';
    }

    private function normalizePath(string $path): string
    {
        $path = (string) \parse_url($path, PHP_URL_PATH);
        $path = '/' . trim($path ?? '/', '/');

        if ($path === '//') {
            $path = '/';
        }
        $parts = \array_values(\array_filter(\explode('/', trim($path, '/')), 'strlen'));

        /**
         * it convert
         * /rest/V1/...
         * /rest/default/V1/...
         * /rest/all/V1/...
         * to:
         * /V1/...
         */
        if (!empty($parts) && $parts[0] === 'rest') {
            \array_shift($parts);
            if (!empty($parts) && preg_match('#^V\d+$#i', $parts[0])) {
                return '/' . \implode('/', $parts);
            }
            if (count($parts) >= 2 && preg_match('#^V\d+$#i', $parts[1])) {
                \array_shift($parts);
                return '/' . \implode('/', $parts);
            }
        }
        return '/' . \implode('/', $parts);
    }
}
