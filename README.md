# Visual Studio Team Services (VSTS) and Team Foundation Server (TFS) Provider for OAuth 2.0 Client
[![Latest Version](https://img.shields.io/github/release/testmonitor/oauth2-vsts.svg?style=flat-square)](https://github.com/testmonitor/oauth2-vsts/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/testmonitor/oauth2-vsts.svg?style=flat-square)](https://packagist.org/testmonitor/oauth2-vsts)
[![Software License](https://img.shields.io/packagist/l/testmonitor/oauth2-vsts.svg?style=flat-square)](LICENSE.md)

This package provides [Visual Studio Team Services (VSTS) and Team Foundation Server (TFS)](https://docs.microsoft.com/en-us/vsts/integrate/) OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Examples](#examples)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

To install the client you need to require the package using composer:

	$ composer require testmonitor/oauth2-vsts

Use composer's autoload:

```php
require __DIR__.'/../vendor/autoload.php';
```

You're all set up now!

## Usage

Usage is the same as The League's OAuth client, using `\Jeylabs\OAuth2\Client\Provider\VSTS` as the provider.

## Examples

```php
$provider = new VSTSProvider([
    'clientId' => $clientId,
    'clientSecret' => $clientSecret,
    'redirectUri' => $redirectUri,
    'urlAuthorize' => 'https://app.vssps.visualstudio.com/oauth2/authorize',
    'urlAccessToken' => 'https://app.vssps.visualstudio.com/oauth2/token',
    'urlResourceOwnerDetails' => 'https://app.vssps.visualstudio.com/oauth2/token/resource',
    'responseType' => 'Assertion',
    'scopes' => 'vso.project vso.work_full',
]);

$token = $provider->getAccessToken('jwt_bearer', [
    'assertion' => $code,
]);
```

## Changelog

Refer to [CHANGELOG](CHANGELOG.md) for more information.

## Contributing

Refer to [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

## Credits

This package is based on [JeyLabs OAuth 2 VSTS](https://github.com/jeylabs/oauth2-vsts).

* **Thijs Kok** - *Lead developer* - [ThijsKok](https://github.com/thijskok)
* **Stephan Grootveld** - *Developer* - [Stefanius](https://github.com/stefanius)
* **Frank Keulen** - *Developer* - [FrankIsGek](https://github.com/frankisgek)
* [All Contributors](https://github.com/testmonitor/oauth2-vsts/contributors)

## License

The MIT License (MIT). Refer to the [License](LICENSE.md) for more information.
