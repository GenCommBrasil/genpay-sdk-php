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

namespace GenComm\Resource\GenLog;

use GenComm\Resource\Resource;
use stdClass;

/**
 * Class Calculation
 * @package GenComm\Resource\GenLog
 */
class Calculation extends Resource
{
    /**
     * @inheritdoc
     */
    protected function initialize()
    {
        $this->data->postage_service_codes = [];
    }

    /**
     * @param $destinationZipcode
     * @return $this
     */
    public function setDestinationZipcode($destinationZipcode)
    {
        $this->data->destination_zipcode = $destinationZipcode;

        return $this;
    }

    /**
     * @param $postageServiceCodes
     * @return $this
     */
    public function setPostageServiceCodes(array $postageServiceCodes)
    {
        $this->data->postage_service_codes = $postageServiceCodes;

        return $this;
    }

    /**
     * @param string $code
     * @param string $name
     * @param int $quantity
     * @param float $cost
     * @param float $width
     * @param float $weight
     * @param float $length
     * @param float $height
     * @return $this
     */
    public function addProducts($code, $name, $quantity, $cost, $width, $weight, $length, $height)
    {
        $products = new stdClass();
        $products->dimensions = new stdClass();

        $products->code = $code;
        $products->name = $name;
        $products->quantity = (int) $quantity;
        $products->cost = (float) $cost;

        $products->dimensions->width = (float) $width;
        $products->dimensions->weight = (float) $weight;
        $products->dimensions->height = (float) $height;
        $products->dimensions->length = (float) $length;
        $this->data->products[] = $products;

        return $this;
    }


}
