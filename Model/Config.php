<?php

namespace Mage4\RestApiRestriction\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private const XML_PATH_ENABLED = 'rest_api_restriction/general/is_enabled';
    private const XML_PATH_DISABLED_ENDPOINTS = 'rest_api_restriction/general/disabled_endpoints';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag('rest_api_restriction/general/is_enabled');
    }

    public function getDisabledEndpoints(): array
    {
        $value = (string) $this->scopeConfig->getValue('rest_api_restriction/general/disabled_endpoints');
        return \array_unique(
            \array_filter(\array_map('trim', \explode(PHP_EOL, $value)))
        );
    }
}
