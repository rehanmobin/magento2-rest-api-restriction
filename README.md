# Rest API Restriction for Magento 2

## Overview

**Mage4 Rest API Restriction** is a Magento 2 extension that allows store administrators to disable selected REST API endpoints without modifying core code or creating endpoint-specific plugins.

The module provides a generic admin configuration where blocked REST API endpoints can be listed one per line. When a request matches one of the configured endpoint patterns, the module throws a **403 Forbidden** API response with a clear error message.

This extension is useful for merchants and developers who want to harden API access, disable unused endpoints, or temporarily restrict selected REST routes.

---

## Install via composer

```
composer require mage4/magento2-rest-api-restriction

php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## Features

- Enable or disable the module from Magento admin
- Restrict specific Magento REST API endpoints
- Configure blocked endpoints from **Stores > Configuration > MAGE4 EXTENSIONS > REST API RESTRICTION**
- Supports Magento-style route placeholders such as:
    - `:cartId`
    - `:sku`
    - `:attributeCode`
- Returns a proper JSON API error response
- Uses a generic validation approach instead of endpoint-specific plugins
- Helps improve API security by disabling unnecessary REST endpoints

---

## Supported Endpoint Pattern Examples

You can configure blocked endpoints like:

```text
/V1/customers/me
/V1/guest-carts/:cartId
/V1/guest-carts/:cartId/totals
/V1/products/:sku
/V1/products/:sku/options
/V1/products/attributes/:attributeCode/is-filterable/:isFilterable
```

---

## About us
We’re an innovative development agency building awesome websites, webshops and web applications with Latest Technologies. Check out our website [mage4.com](http://mage4.com/) or email us at [contact@mage4.com](mailto:contact@mage4.com) | [rehan@mage4.com](mailto:rehan@mage4.com).
