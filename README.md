YproximiteEkomiApiBundle
========================

Integration of the [**eKomi API client**](https://github.com/Yproximite/ekomi-api)
library into Symfony3.

* [Installation](#installation)
* [Usage](#usage)

Installation
------------

Require
[`yproximite/ekomi-api-bundle`](https://packagist.org/packages/yproximite/ekomi-api-bundle)
to your `composer.json` file:

```
$ composer require yproximite/ekomi-api-bundle
```

Register the bundle in `app/AppKernel.php`:

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Yproximite\Bundle\EkomiApiBundle\YproximiteEkomiApiBundle(),
    );
}
```

Enable the bundle's configuration in `app/config/config.yml`:

```yaml
# app/config/config.yml
yproximite_ekomi_api:

    # Identifier of the service that represents "Http\Client\HttpClient"
    http_client: httplug.client.guzzle6

    # Credentials
    client_id: 999999
    secret_key: xxxxxxxxxxxxxx

    # Base url for the API, optional, by default is "https://csv.ekomi.com/api/3.0"
    base_url: https://csv.ekomi.com/api/3.0

    # cache
    cache: cache.app
    cache_key: xxxxx
```

Usage
-----

```php
use Yproximite\Ekomi\Api\Message\Order\OrderListMessage;

$api = $this->get('yproximite.ekomi_api.service_aggregator');

$message = new OrderListMessage();
$message->setOffset(5);
$message->setLimit(10);
$message->setOrderBy(OrderListMessage::ORDER_BY_CREATED);
$message->setOrderDirection(OrderListMessage::ORDER_DIRECTION_DESC);
$message->setWithFeedbackOnly(true);
$message->setCreatedFrom(new \DateTime('2016-10-06 00:00:10'));
$message->setCreatedTill(new \DateTime('2016-11-06 00:14:29'));
$message->setShopId(11);
$message->setCustomDataFilter(['vendor_id' => 123]);

// Yproximite\Ekomi\Api\Model\Order\Order[]
$orders = $api->order()->getOrders($message);
```
