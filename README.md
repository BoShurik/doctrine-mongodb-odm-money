# Doctrine ODM Money Type Integration

Use [`michaelgooden/mdg-money-doctrine`](https://github.com/MichaelGooden/mdg-money-doctrine) for ORM inegration


## Installation

Add `vendor/boshurik/doctrine-mongodb-odm-money/config/Money.mongodb.xml` to mapping

```php
Doctrine\ODM\MongoDB\Types\Type

Type::registerType('currency', \BoShurik\Money\Doctrine\ODM\MongoDB\Types\CurrencyType::class);
```

### Symfony integration

- Add CurrencyType (i.e. in `Kernel`)
```php

use BoShurik\Money\Doctrine\ODM\MongoDB\Types\CurrencyType;

class Kernel extends BaseKernel
{
    public function __construct(string $environment, bool $debug)
    {
        parent::__construct($environment, $debug);
    
        Type::addType('currency', CurrencyType::class);
    }
    
    // ...
}
```

- Add mapping to `doctrine_mongodb.yaml`
```yaml
doctrine_mongodb:
    document_managers:
        default:
            mappings:
                Money:
                    is_bundle: false
                    type: xml
                    dir: '%kernel.project_dir%/vendor/boshurik/doctrine-mongodb-odm-money/config'
                    prefix: Money
```
