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

namespace Rakuten\Tests\Unit\Parser\RakutenLog\Transaction;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\RakutenLog\Transaction\Autocomplete;
use Rakuten\Connector\Service\Http\Response\Response;

class AutocompleteTest extends TestCase
{
    /**
     * @var Autocomplete
     */
    private $autocomplete;

    public function setUp()
    {
        $this->autocomplete = new Autocomplete();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult("Autocomplete Transaction Response");
        
        $street = "Rua Bela Cintra";
        $district = "Consolação";
        $city = "São Paulo";
        $state = "SP";
        $zipcode = "01415001";

        $this->autocomplete->setStreet($street);
        $this->autocomplete->setDistrict($district);
        $this->autocomplete->setCity($city);
        $this->autocomplete->setState($state);
        $this->autocomplete->setZipcode($zipcode);
        $this->autocomplete->setResponse($response);
        $this->autocomplete->setMessage('');

        $this->assertInstanceOf(Autocomplete::class, $this->autocomplete);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($street, $this->autocomplete->getStreet(), "Autocomplete Street");
        $this->assertEquals($district, $this->autocomplete->getDistrict(), "Autocomplete District");
        $this->assertEquals($city, $this->autocomplete->getCity(), "Autocomplete City");
        $this->assertEquals($state, $this->autocomplete->getState(), "Autocomplete State");
        $this->assertEquals($zipcode, $this->autocomplete->getZipcode(), "Autocomplete Zipcode");
        $this->assertEquals(Status::OK, $this->autocomplete->getResponse()->getStatus(), "Autcomplete Response Statuas");
        $this->assertEmpty($this->autocomplete->getMessage());
    }
}
