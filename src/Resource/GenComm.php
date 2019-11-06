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

/**
 * Class GenComm
 * @package GenComm
 */
class GenComm implements Credential
{
    const CURRENCY = "BRL";

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var string
     */
    private $document;

    /**
     * GenComm constructor.
     * @param $document
     * @param $apiKey
     * @param $signature
     * @param $environment
     */
    public function __construct($document, $apiKey, $signature, $environment)
    {
        $this->document = $document;
        $this->apiKey = $apiKey;
        $this->signature = $signature;
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @return mixed
     */
    public function getDocument()
    {
        return $this->document;
    }
}