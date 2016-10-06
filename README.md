YproximiteEkomiApiBundle
========================

Integration of the [**eKomi API client**](https://github.com/Yproximite/ekomi-api)
library into Symfony3.

* [Installation](#installation)
* [Usage](#usage)

Installation
------------

Require
[`yproximite/ekomi-api-bundle`](https://github.com/Yproximite/EkomiBundle)
to your `composer.json` file:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:Yproximite/ekomi-api-bundle"
        }
    ],
    "require": {
        "yproximite/ekomi-api-bundle": "dev-master"
    }
}
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

``` yaml
# app/config/config.yml
yproximite_ekomi_api:
    client_id: 999999
    secret_key: xxxxxxxxxxxxxx
```

Usage
-----

```php
use Yproximite\Ekomi\Api\Model\OrderCollection;

$request = new GetOrdersRequest();
$request
    ->setOffset(5)
    ->setLimit(10)
    ->setCreatedFrom(new \DateTime('2016-10-06 00:00:10'))
;

// @var OrderCollection
$response = $this->get('yproximite.ekomi_api.client')->sendRequest($request);
```
