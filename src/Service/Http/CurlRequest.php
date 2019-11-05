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

namespace GenComm\Service\Http;

use GenComm\Resource\GenComm;
use GenComm\Exception\GenCommException;
use GenComm\Service\Http\Response\Response;

/**
 * Class CurlRequest
 * @package GenComm\Service\Http
 */
abstract class CurlRequest implements Method
{
    /**
     * @var false|resource|null
     */
    private $handle = null;

    /**
     * @var GenComm
     */
    protected $genComm;

    /**
     * @var Response
     */
    protected $response;

    /**
     * CurlRequest constructor.
     * @param GenComm $genComm
     */
    public function __construct(GenComm $genComm)
    {
        $this->handle = curl_init();
        $this->genComm = $genComm;
        $this->response = new Response();
    }

    /**
     * @param $method
     * @param $url
     * @param $timeout
     * @param $charset
     * @param string $data
     * @param bool $secureGet
     * @return mixed
     */
    abstract protected function curlConnection($method, $url, $timeout, $charset, $data = '', $secureGet = true);

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array $options
     */
    protected function setOption(array $options)
    {
        curl_setopt_array($this->handle, $options);
    }

    /**
     * @return bool|string
     */
    protected function execute()
    {
        return curl_exec($this->handle);
    }

    /**
     * @return mixed
     */
    protected function getInfo()
    {
        return curl_getinfo($this->handle);
    }

    /**
     * @return int
     */
    protected function getErrorCode()
    {
        return curl_errno($this->handle);
    }

    /**
     * @return string
     */
    protected function getErrorMessage()
    {
        return curl_error($this->handle);
    }

    /**
     * @return void
     */
    protected function close()
    {
        curl_close($this->handle);
    }

    /**
     * @param $url
     * @param string $data
     * @param int $timeout
     * @param string $charset
     * @return bool
     */
    public function post($url, $data = '', $timeout = 20, $charset = 'ISO-8859-1')
    {
        return $this->curlConnection('POST', $url, $timeout, $charset, $data);
    }

    /**
     * @param $url
     * @param int $timeout
     * @param string $charset
     * @return bool
     * @throws GenCommException
     */
    public function get($url, $timeout = 20, $charset = 'ISO-8859-1', $secureGet = true)
    {
        return $this->curlConnection('GET', $url, $timeout, $charset, null, $secureGet);
    }
}