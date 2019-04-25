<?php
namespace Rakuten\Tests\Unit\Resource\RakutenPay;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Resource\RakutenPay\Customer;

class CustomerTest extends TestCase
{
    /**
     * @var Customer
     */
    private $customer;

    public function setUp()
    {
        $stub = $this->createMock(RakutenPay::class);
        $this->customer = new Customer($stub);
    }

    public function testItShouldInstanceOfCustomer()
    {
        $this->assertInstanceOf("Rakuten\Connector\Resource\RakutenPay\Customer", $this->customer);
    }

    public function testReturnDataStdClass()
    {
        $name = "Maria";
        $birthDate = "1985-04-16";
        $businessName = "Sra. Maria";
        $document = "12345678909";
        $email = "teste@teste.com.br";
        $kind = "personal";

        $this->customer->setName($name);
        $this->customer->setBirthDate($birthDate);
        $this->customer->setBusinessName($businessName);
        $this->customer->setDocument($document);
        $this->customer->setEmail($email);
        $this->customer->setKind($kind);
        $this->customer->addAddress("shipping",
                "09840-500",
                "Rua Dos Morros",
                "1000",
                "ABC",
                "Maua",
                "SP",
                "Maria",
                "")
            ->addAddress("billing",
                "09840-500",
                "Rua Dos Morros",
                "1000",
                "ABC",
                "Maua",
                "SP",
                "Maria",
                "")
            ->addAPhones("others",
                "999999998",
                "55",
                "11",
                "shipping")
            ->addAPhones("others",
                "999999998",
                "55",
                "11",
                "billing");

        $data = $this->customer->getData();

        $this->assertInstanceOf(\stdClass::class, $data);
        $this->assertEquals($name, $data->name, "Name from Customer");
        $this->assertEquals($birthDate, $data->birth_date, "Birth Data from Customer");
        $this->assertEquals($businessName, $data->business_name, "Business Name from Customer");
        $this->assertEquals($document, $data->document, "Document Tax Number/CNPJ from Customer");
        $this->assertEquals($email, $data->email, "Email from Customer");
        $this->assertEquals($kind, $data->kind, "Kind from Customer");
        $this->assertCount(2, $data->addresses, "Count Addresses");
        $this->assertCount(2, $data->phones, "Count Phones");
    }
}