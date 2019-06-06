<?php
/**
 ************************************************************************
 * Copyright [2018] [RakutenConnector]
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

namespace Rakuten\Connector\Enum;

/**
 * Class Enum
 * @package Rakuten\Connector\Enum
 */
abstract class Enum
{
    /**
     * @var null
     */
    private static $constCacheArray = null;

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    protected static function getConstants()
    {
        if (self::$constCacheArray == null) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function getList()
    {
        $reflection = new \ReflectionClass(get_called_class());

        return $reflection->getConstants();
    }

    /**
     * @param $key
     * @return bool|false|int|string
     * @throws \ReflectionException
     */
    public static function getType($key)
    {
        $declared = self::getList();
        if (array_search($key, $declared)) {

            return array_search($key, $declared);
        } else {

            return false;
        }
    }

    /**
     * @param $value
     * @return bool
     * @throws \ReflectionException
     */
    public static function getValue($value)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, true);
    }
}
