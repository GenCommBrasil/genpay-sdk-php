<?php
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
