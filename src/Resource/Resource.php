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

namespace Rakuten\Connector\Resource;

use stdClass;

/**
 * Class Resource
 * @package Rakuten\Connector\Resource
 */
abstract class Resource
{
    /**
     * @var RakutenConnector
     */
    protected $rakutenConnector;

    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * Resource constructor.
     * @param RakutenConnector $rakutenConnector
     */
    public function __construct(RakutenConnector $rakutenConnector)
    {
        $this->rakutenConnector = $rakutenConnector;
        $this->data = new stdClass();
        $this->initialize();
    }

    /**
     * Initialize a new instance.
     */
    abstract protected function initialize();

    /**
     * @return stdClass
     */
    public function getData()
    {
        return $this->data;
    }
}
