<?php

namespace Rakuten\Connector\Service\Http;

use Rakuten\Connector\Resource\RakutenConnector;
use Rakuten\Connector\Exception\RakutenException;
use Rakuten\Connector\Service\Http\Response\Response;

/**
 * Class CurlRequest
 * @package Rakuten\Connector\Service\Http
 */
abstract class CurlRequest extends Response implements Method
{
    /**
     * @var false|resource|null
     */
    private $handle = null;

    /**
     * @var RakutenConnector
     */
    protected $rakutenConnector;

    /**
     * CurlRequest constructor.
     * @param RakutenConnector $rakutenConnector
     */
    public function __construct(RakutenConnector $rakutenConnector)
    {
        $this->handle = curl_init();
        $this->rakutenConnector = $rakutenConnector;
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
     * @throws RakutenException
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
     * @throws RakutenException
     */
    public function get($url, $timeout = 20, $charset = 'ISO-8859-1', $secureGet = true)
    {
        return $this->curlConnection('GET', $url, $timeout, $charset, null, $secureGet);
    }
}