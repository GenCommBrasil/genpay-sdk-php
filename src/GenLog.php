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

namespace GenComm;

use GenComm\Enum\Endpoint;
use GenComm\Parser\GenLog\Autocomplete;
use GenComm\Parser\GenLog\Factory;
use GenComm\Parser\GenLog\OrderDetail;
use GenComm\Resource\GenComm;
use GenComm\Resource\Credential;
use GenComm\Resource\GenLog\Batch;
use GenComm\Resource\GenLog\Calculation;
use GenComm\Exception\GenCommException;
use GenComm\Service\Http\Responsibility;
use GenComm\Service\Http\Webservice;

/**
 * Class GenLog
 * @package GenComm
 */
class GenLog extends GenComm implements Credential
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
     * @throws GenCommException
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
        } catch (GenCommException $e) {
            throw $e;
        }
    }

    /**
     * @param Batch $batch
     * @return mixed
     * @throws GenCommException
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
        } catch (GenCommException $e) {
            throw $e;
        }
    }

    /**
     * @param $zipcode
     * @param bool $online
     * @return mixed
     * @throws GenCommException
     */
    public function autocomplete($zipcode, $online = false)
    {
        try {
            $webservice = $this->getWebservice();
            $url = Endpoint::buildAutocompleteUrl($this->getEnvironment(), $online) . Endpoint::URL_SEPARATOR . $zipcode;
            $webservice->get($url);
            $response = Responsibility::http($webservice, new Autocomplete());

            return $response;
        } catch (GenCommException $e) {
            throw $e;
        }
    }

    /**
     * @param $orderId
     * @return mixed
     * @throws GenCommException
     */
    public function orderDetail($orderId)
    {
        try {
            $webservice = $this->getWebservice();
            $url = Endpoint::buildOrderDetailUrl($this->getEnvironment()) . Endpoint::URL_SEPARATOR . $orderId;
            $webservice->get($url);
            $response = Responsibility::http($webservice, new OrderDetail());

            return $response;
        } catch (GenCommException $e) {
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

