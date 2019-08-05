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

namespace Rakuten\Connector;

use Rakuten\Connector\Enum\Endpoint;
use Rakuten\Connector\Parser\RakutenLog\Autocomplete;
use Rakuten\Connector\Parser\RakutenLog\Factory;
use Rakuten\Connector\Parser\RakutenLog\OrderDetail;
use Rakuten\Connector\Resource\RakutenConnector;
use Rakuten\Connector\Resource\Credential;
use Rakuten\Connector\Resource\RakutenLog\Batch;
use Rakuten\Connector\Resource\RakutenLog\Calculation;
use Rakuten\Connector\Exception\RakutenException;
use Rakuten\Connector\Service\Http\Responsibility;
use Rakuten\Connector\Service\Http\Webservice;

/**
 * Class RakutenLog
 * @package Rakuten\Connector
 */
class RakutenLog extends RakutenConnector implements Credential
{
    /**
     * @var \stdClass
     */
    private $data;

    /**
     * @return Calculation
     */
    public function calculation()
    {
        return new Calculation($this);
    }

    /**
     * @return Batch
     */
    public function batch()
    {
        return new Batch($this);
    }

    /**
     * @param Calculation $calculation
     * @return mixed
     * @throws RakutenException
     */
    public function createCalculation(Calculation $calculation)
    {
        $this->data = $calculation->getData();
        try {
            $transaction = Factory::create(get_class($calculation));
            $webservice = $this->getWebservice();

            $data = json_encode($this->data, JSON_PRESERVE_ZERO_FRACTION);
            $webservice->post(
                Endpoint::createCalculationUrl($this->getEnvironment()),
                $data
            );

            $response = Responsibility::http(
                $webservice,
                $transaction
            );

            return $response;
        } catch (RakutenException $e) {
            throw $e;
        }
    }

    /**
     * @param Batch $batch
     * @return mixed
     * @throws RakutenException
     */
    public function generateBatch(Batch $batch)
    {
        $this->data[] = $batch->getData();
        try {
            $transaction = Factory::create(get_class($batch));
            $webservice = $this->getWebservice();

            $data = json_encode($this->data, JSON_PRESERVE_ZERO_FRACTION);
            $webservice->post(
                Endpoint::generateBatchUrl($this->getEnvironment()),
                $data
            );

            $response = Responsibility::http(
                $webservice,
                $transaction
            );

            return $response;
        } catch (RakutenException $e) {
            throw $e;
        }
    }

    /**
     * @param $zipcode
     * @param bool $online
     * @return mixed
     * @throws RakutenException
     */
    public function autocomplete($zipcode, $online = false)
    {
        try {
            $webservice = $this->getWebservice();
            $url = Endpoint::buildAutocompleteUrl($this->getEnvironment(), $online) . Endpoint::URL_SEPARATOR . $zipcode;
            $webservice->get($url);
            $response = Responsibility::http($webservice, new Autocomplete());

            return $response;
        } catch (RakutenException $e) {
            throw $e;
        }
    }

    /**
     * @param $orderId
     * @return mixed
     * @throws RakutenException
     */
    public function orderDetail($orderId)
    {
        try {
            $webservice = $this->getWebservice();
            $url = Endpoint::buildOrderDetailUrl($this->getEnvironment()) . Endpoint::URL_SEPARATOR . $orderId;
            $webservice->get($url);
            $response = Responsibility::http($webservice, new OrderDetail());

            return $response;
        } catch (RakutenException $e) {
            throw $e;
        }
    }

    /**
     * @return Webservice
     */
    protected function getWebservice()
    {
        return new Webservice($this);
    }
}

