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

/**
 * Class Error
 * @package Rakuten\Connector\Parser
 */
class Error implements Transaction
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $code;

    /**
     * @param $status
     * @return $this|Transaction
     */
    public function setStatus($status)
    {
        $this->status = (int) $status;

        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
