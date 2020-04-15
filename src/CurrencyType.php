<?php
/**
 * User: boshurik
 * Date: 2019-01-11
 * Time: 12:16
 */

namespace BoShurik\Money\Doctrine\ODM\MongoDB\Types;

use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Doctrine\ODM\MongoDB\Types\Type;
use Money\Currency;

class CurrencyType extends Type
{
    /**
     * @param $value
     * @return Currency
     * @throws MappingException
     */
    public static function getCurrencyValue($value)
    {
        try {
            $currency = new Currency($value);
        } catch (\InvalidArgumentException $e) {
            throw new MappingException('Failed to convert currency');
        }

        return $currency;
    }

    public function convertToDatabaseValue($value)
    {
        if (empty($value)) {
            return null;
        }
        if (!$value instanceof Currency) {
            throw new MappingException('Value must be an instance of '. Currency::class);
        }

        return $value->getCode();
    }

    public function convertToPHPValue($value)
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof Currency) {
            return $value;
        }

        return static::getCurrencyValue($value);
    }

    public function closureToMongo(): string
    {
        return 'if ($value === null) { $return = null; } else { $return = $value->getCode(); }';
    }

    public function closureToPHP(): string
    {
        return 'if ($value === null) { $return = null; } else { $return = \\'.get_class($this).'::getCurrencyValue($value);  }';
    }
}