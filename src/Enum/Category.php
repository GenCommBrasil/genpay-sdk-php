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

namespace Rakuten\Connector\Enum;

use Rakuten\Connector\Exception\RakutenException;

/**
 * Class Category
 * @package Rakuten\Connector\Enum
 */
class Category
{
    /**
     * Category ID.
     *
     * @const string
     */
    const ID = 'id';

    /**
     * Category Name.
     *
     * @const string
     */
    const NAME = 'name';

    /**
     * Category ID Default
     *
     * @const string
     */
    const DEFAULT_ID = '99';

    /**
     * * Category Name Default
     *
     * @const string
     */
    const DEFAULT_NAME = 'Outros';

    /**
     * @var array
     */
    private static $defaultCategory = [
        self::ID => self::DEFAULT_ID,
        self::NAME => self::DEFAULT_NAME
    ];

    /**
     * @param string $id
     * @param string $name
     * @return array
     * @throws RakutenException
     */
    public static function getCategory($id, $name)
    {
        if (empty($id) && empty($name)) {
            throw new RakutenException('Error id or name is required.');
        }

        return [self::ID => (string) $id, self::NAME => $name];
    }

    /**
     * @return array
     */
    public static function getDefaultCategory()
    {
        return self::$defaultCategory;
    }
}