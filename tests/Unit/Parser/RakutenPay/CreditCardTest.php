<?php
namespace Rakuten\Tests\Unit\Parser;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Parser\RakutenPay\CreditCard;

class CreditCardTest extends TestCase
{
    /**
     * @var Webservice
     */
    private $webservice;

    public function setUp()
    {
        $stub = $this->createMock(RakutenPay::class);
        $this->webservice = new Webservice($stub);
    }

    public function testShouldSucceedAndReturnTransactionCreditCard()
    {
        $this->webservice->setStatus(200);
        $this->webservice->setResponse($this->getDataSuccess());

        $response = CreditCard::success($this->webservice);

        $this->assertInstanceOf(\Rakuten\Connector\Parser\RakutenPay\Transaction\CreditCard::class, $response);
        $this->assertEquals('fake-charge-uuid', $response->getChargeId(), "Charge UUID");
        $this->assertEquals('411111******1111', $response->getCreditCardNum(), "Credit Card Number");
        $this->assertEquals('authorized', $response->getStatus(), "Status Code");
    }

    public function testShouldErrorAndReturnErrorClass()
    {
        $this->webservice->setStatus(422);
        $this->webservice->setResponse($this->getDataError());

        $response = CreditCard::error($this->webservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertEquals(422, $response->getCode(), "Code Status");
        $this->assertEquals("Installments amount doesnt match. Payment credit_card in 3 times of 70.90 should be 212.70", $response->getMessage(), "Error Message");
    }

    public function testCallMethodSuccessAndReturnErrorClass()
    {
        $this->webservice->setStatus(422);
        $this->webservice->setResponse($this->getDataError());

        $response = CreditCard::success($this->webservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertEquals(422, $response->getCode(), "Code Status");
        $this->assertEquals("Installments amount doesnt match. Payment credit_card in 3 times of 70.90 should be 212.70", $response->getMessage(), "Error Message");
    }

    /**
     * @return string
     */
    protected function getDataSuccess()
    {
        $jsonSuccess = '
        {
          "shipping": {
            "time": null,
            "kind": null,
            "company": null,
            "amount": 0.0,
            "adjustments": []
          },
          "result_messages": [],
          "result": "success",
          "reference": "160",
          "payments": [
            {
              "status": "authorized",
              "result_messages": [],
              "result": "success",
              "refundable_amount": 100.0,
              "reference": "1",
              "method": "credit_card",
              "id": "SDG-DSG-DS-G-DS",
              "credit_card": {
                "tid": "11111111111111",
                "processor": "cielo",
                "number": "411111******1111",
                "nsu": "492734",
                "authorization_message": "Transaction Approved",
                "authorization_code": "123456"
              },
              "amount": 100.0
            }
          ],
          "fingerprint": "fake-fingerprint",
          "commissionings": [],
          "charge_uuid": "fake-charge-uuid"
        }';

        return $jsonSuccess;
    }

    /**
     * @return string
     */
    protected function getDataError()
    {
        $jsonError = '
        {
          "result_messages": [
            "Installments amount doesnt match. Payment credit_card in 3 times of 70.90 should be 212.70"
          ],
          "result_code": {
            "message": [
              "Installments amount doesnt match. Payment credit_card in 3 times of 70.90 should be 212.70"
            ],
            "code": 999
          },
          "result": "failure",
          "reference": "",
          "payments": [],
          "charge_uuid": ""
        }                
        ';

        return $jsonError;
    }
}
