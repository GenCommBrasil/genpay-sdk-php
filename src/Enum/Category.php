<?php
/**
 ************************************************************************
 * Copyright [2019] [GenComm]
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

namespace GenComm\Enum;

use GenComm\Exception\GenCommException;

/**
 * Class Category
 * @package GenComm\Enum
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
     * @throws GenCommException
     */
    public static function getCategory($id, $name)
    {
        $id = is_string($id) ? trim($id) : $id;
        $name = trim($name);
        if (empty($id) || empty($name)) {
            return [self::ID => self::DEFAULT_ID, self::NAME => self::DEFAULT_NAME];
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