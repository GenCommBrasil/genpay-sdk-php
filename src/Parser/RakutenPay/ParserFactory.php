<?php

namespace Rakuten\Connector\Parser\RakutenPay;

use Rakuten\Connector\Exception\RakutenException;

/**
 * Class ParserFactory
 * @package Rakuten\Connector\Parser\RakutenPay
 */
abstract class ParserFactory
{
    /**
     * @param string $class
     * @return Object
     * @throws RakutenException
     */
    public static function create($class)
    {
        if (!class_exists($class)) {
            throw new RakutenException("Class not Exists in TransactionFactory");
        }

        $class = self::getClass($class);

        return new $class;
    }

    /**
     * @param $class
     * @return string
     */
    protected static function getClass($class)
    {
        $namespace = "Rakuten\Connector\Parser\RakutenPay";

        if (strpos($class, "\\"))
        {
            $classArray = explode("\\", $class);
            $class = array_pop($classArray);
        }

        return $namespace . "\\" . $class;
    }
}
