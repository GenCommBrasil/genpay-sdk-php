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

namespace GenComm\Resource;

use stdClass;

/**
 * Class Resource
 * @package GenComm\Resource
 */
abstract class Resource
{
    /**
     * @var GenComm
     */
    protected $genComm;

    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * Resource constructor.
     * @param GenComm $genComm
     */
    public function __construct(GenComm $genComm)
    {
        $this->genComm = $genComm;
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
