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

namespace Rakuten\Connector\Parser;

use Rakuten\Connector\Exception\RakutenException;

/**
 * Class ParserFactory
 * @package Rakuten\Connector\Parser
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

        $class = static::getClass($class);

        return new $class;
    }

    /**
     * @param $class
     * @return string
     */
    protected abstract static function getClass($class);
}
