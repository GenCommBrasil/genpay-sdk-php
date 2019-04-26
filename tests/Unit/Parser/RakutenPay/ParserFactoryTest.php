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

namespace Rakuten\Tests\Unit\Parser;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Exception\RakutenException;
use Rakuten\Connector\Parser\RakutenPay\Billet;
use Rakuten\Connector\Parser\RakutenPay\CreditCard;
use Rakuten\Connector\Parser\RakutenPay\ParserFactory;

class ParserFactoryTest extends TestCase
{
    public function testGetClassByNamespace()
    {
        $parserBillet = ParserFactory::create('Rakuten\Connector\Resource\RakutenPay\Billet');
        $parserCreditCard = ParserFactory::create('Rakuten\Connector\Resource\RakutenPay\CreditCard');

        $this->assertInstanceOf(Billet::class, $parserBillet);
        $this->assertInstanceOf(CreditCard::class, $parserCreditCard);
    }

    public function testGetClassByClassNameAndGenerateException()
    {
        $this->expectException(RakutenException::class);
        $this->expectExceptionMessage("Class not Exists in TransactionFactory");
        ParserFactory::create('Billet');
    }
}
