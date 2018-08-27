# Portmone Integration
[![Latest Stable Version](https://poser.pugx.org/wearesho-team/portmone/v/stable.png)](https://packagist.org/packages/wearesho-team/portmone)
[![Total Downloads](https://poser.pugx.org/wearesho-team/portmone/downloads.png)](https://packagist.org/packages/wearesho-team/portmone)
[![Build Status](https://travis-ci.org/wearesho-team/portmone.svg?branch=master)](https://travis-ci.org/wearesho-team/portmone)
[![codecov](https://codecov.io/gh/wearesho-team/portmone/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/portmone)

[Portmone](https://portmone.com.ua) integration for PHP.

## Installation
Using composer:
```bash
composer require wearesho-team/portmone
```

## Usage
### Configuration
For configuration you have to use [ConfigInterface](./src/ConfigInterface.php). Available implementations:

- [Config](./src/Config.php) - simple entity. Example:

```php
<?php

use Wearesho\Bobra\Portmone;

$config = new Portmone\Config("Key", "Secret", "Payee", "Language", "Url");
```

- [EnvironmentConfig](./src/EnvironmentConfig.php) - configuration using getenv. Example:

```php
<?php

use Wearesho\Bobra\Portmone;

$config = new Portmone\EnvironmentConfig();
```

Environment configuration:

|      Variable     | Required |                Default               |          Description          |
|:-----------------:|:--------:|:------------------------------------:|:-----------------------------:|
| PORTMONE_KEY      | yes      |                                      | public key (login)            |
| PORTMONE_SECRET   | yes      |                                      | private key (password)        |
| PORTMONE_PAYEE    | yes      |                                      | your company id               |
| PORTMONE_URL      | no       | https://www.portmone.com.ua/gateway/ | base url to make requests     |
| PORTMONE_LANGUAGE | no       | ru                                   | transaction language          |

### Generating payment configuration
Use [Client](./src/Client.php) to fetch payment config

```php
<?php

use Wearesho\Bobra\Portmone;
use Wearesho\Bobra\Payments;

$config = new Portmone\EnvironmentConfig();
$client = new Portmone\Client($config);

$payment = $client->createPayment(
    new Payments\UrlPair(
        'http://redirect-url-on-success',
        'http://redirect-url-on-fail'
    ),
    new Payments\Transaction(
        $serviceId = 1,
        $amount = 500,
        $paymentType = 'paymentType',
        $description = 'description for payment',
        $ext = [
            'attribute1' => 'some-info',
            'attribute2' => 'some-info'            
        ] // optional, will be returned in notification
    )
);
```

### Rendering form

```php
<?php

$config = $payment->jsonSerialize(); // ['action' => 'URL', 'data' => 'url']
```

### Notifications

```php
<?php

use Wearesho\Bobra\Portmone\Config;
use Wearesho\Bobra\Portmone\Direct;

class PortmoneController
{
    public function actionHandle()
    {
        $config = new Config("Key", "Secret", "Payee");
        $server = new Direct\Server($config);
        
        try {
            // All messages are instance of Portmone\NotificationInterface
            $message = $server->handle($_POST['data']);
        } catch (InvalidDataException $exception) {
            // Handle invalid data exception
            // On this exception you need to return response on post message
            // Use getBodyMessage to generate answer with error message
            $body = $server->getBodyMessage(
                Direct\Message::SYSTEM_ERROR, 
                new Direct\Message(
                    $code = Direct\Message::TECH_ERROR,
                    $message = 'some-description',
                    $documentId = 'id' // id of post-document from Portmone in your company system
                )
            );
        }
        
        // Messages can be one of three instances
        $isInternalRequest = $message instanceof Direct\InternalRequest;
        $isInternalPayment = $message instanceof Direct\InternalPayment;
        $isBankPayment = $message instanceof Direct\BankPayment;
        
        // On every message need to generate response
        if ($isInternalRequest) {
            // if your system is correctly work use:
            $response = $server->getBodyPayersResponse(
                new Direct\PayersResponse(
                    new Direct\Collections\IdentifiedPayers([
                        new Direct\Entities\IdentifiedPayer(...)
                    ]),
                    new Direct\Collections\RejectedPayers([
                        new Direct\Entities\RejectedPayer(...)
                    ])
                )
            );
            // if for technical reasons it is impossible to answer correctly use:
            $response = $server->getBodyMessage(
                Direct\Message::TECH_ERROR, 
                new Direct\Message(
                    $code = Direct\Message::TECH_ERROR,
                    $message = 'some-description',
                    $documentId = 'id' // id of post-document from Portmone in your company system
                )
            );
        } else if ($isInternalPayment || $isBankPayment) {
            $response = $server->getBodyNotificationResponse($documentId = 123);
        }
    }
}
```

### C2C Payment

Use [Credit\Client](./src/Credit/Client.php) for C2C payments. Example:

```php
<?php

use GuzzleHttp;
use Wearesho\Bobra\Portmone;
use Wearesho\Bobra\Payments;

$config = new Portmone\EnvironmentConfig();
$client = new Portmone\Credit\Client($config, new GuzzleHttp\Client());

$payment = $client->send(new Payments\Credit\Transfer(
    $id = 123,
    $amount = 2500.50,
    $cardToken = '1234567812345678',
    $description = 'some-description'
));
```

## Author
- [Wearesho](https://wearesho.com)
- [Alexander Letnikow](mailto:reclamme@gmail.com)
- [Roman Varkuta](mailto:roman.varkuta@gmail.com)
- [Alexander Yagich](mailto:aleksa.yagich@gmail.com)

## License
[MIT](./LICENSE.md)
