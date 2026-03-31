<?php

namespace Mage4\RestApiRestriction\Plugin\Webapi\Rest;

use Mage4\RestApiRestriction\Model\Config;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
use Magento\Framework\Webapi\Exception as WebapiException;
use Magento\Framework\Webapi\Rest\RequestMethodValidator;
use Mage4\RestApiRestriction\Model\EndpointMatcher;

class RequestMethodValidatorPlugin
{
    public function __construct(
        private readonly Config $config,
        private readonly RestRequest $restRequest,
        private readonly EndpointMatcher $endpointMatcher
    ) {
    }

    public function beforeValidate(RequestMethodValidator $subject): void
    {
        if (!$this->config->isEnabled()) {
            return;
        }
        $path = $this->restRequest->getPathInfo();
        if ($this->endpointMatcher->isBlocked($path, $this->config->getDisabledEndpoints())) {
            throw new WebapiException(
                __('This API is disabled.'),
                0,
                WebapiException::HTTP_FORBIDDEN
            );
        }
    }
}
