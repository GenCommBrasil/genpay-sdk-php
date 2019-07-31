<?php
/**
 ************************************************************************
 * Copyright [2019] [RakutenConnector]
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ************************************************************************
 */

namespace Rakuten\Connector\Parser\RakutenPay;

use Rakuten\Connector\Parser\ParserFactory;
use Rakuten\Connector\Exception\RakutenException;

/**
 * Class Factory
 * @package Rakuten\Connector\Parser\RakutePay
 */
abstract class Factory extends ParserFactory
{
    /**
     * @param $class
     * @return mixed
     * @throws RakutenException
     * @throws \ReflectionException
     */
    public static function create($class)
    {
        if (!class_exists($class)) {
            throw new RakutenException("Class not Exists in TransactionFactory");
        }

        $class = self::getClass($class);

        return new $class;
    }
}
