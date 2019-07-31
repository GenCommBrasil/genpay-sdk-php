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
use \ReflectionClass;

/**
 * Class ParserFactory
 * @package Rakuten\Connector\Parser
 */
abstract class ParserFactory
{
    /**
     * @param $class
     * @return mixed
     * @throws RakutenException
     * @throws \ReflectionException
     */
    abstract public static function create($class);

    /**
     * @param $class
     * @return string
     * @throws \ReflectionException
     */
    protected static function getClass($class)
    {
        $reflector = new ReflectionClass(get_called_class());
        $namespace = $reflector->getNamespaceName();

        if (strpos($class, "\\"))
        {
            $classArray = explode("\\", $class);
            $class = array_pop($classArray);
        }

        return $namespace . "\\" . $class;
    }
}
