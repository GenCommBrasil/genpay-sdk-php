<?php
namespace Rakuten\Tests\Unit\Parser;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Parser\RakutenPay\Billet;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\RakutenPay;

class BilletTest extends TestCase
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

    public function testShouldSucceedAndReturnTransactionBillet()
    {
        $this->webservice->setStatus(200);
        $this->webservice->setResponse($this->getDataSuccess());

        $response = Billet::success($this->webservice);

        $this->assertInstanceOf(\Rakuten\Connector\Parser\RakutenPay\Transaction\Billet::class, $response);
        $this->assertEquals('fake-charge-uuid', $response->getChargeId(), "Charge UUID");
        $this->assertEquals('fake-download-url', $response->getBillet(), "Billet URL");
        $this->assertEquals('fake-url', $response->getBilletUrl(), "Billet URL");
    }

    public function testShouldErrorAndReturnErrorClass()
    {
        $this->webservice->setStatus(422);
        $this->webservice->setResponse($this->getDataError());

        $response = Billet::error($this->webservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertEquals(422, $response->getCode(), "Code Status");
        $this->assertEquals("Sum of payments amount doesnt match with amount", $response->getMessage(), "Error Message");
    }

    public function testCallMethodSuccessAndReturnErrorClass()
    {
        $this->webservice->setStatus(422);
        $this->webservice->setResponse($this->getDataError());

        $response = Billet::success($this->webservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertEquals(422, $response->getCode(), "Code Status");
        $this->assertEquals("Sum of payments amount doesnt match with amount", $response->getMessage(), "Error Message");
    }

    /**
     * @return string
     */
    protected function getDataSuccess()
    {
        $jsonSuccess = '
        {  
           "shipping":{  
              "time":null,
              "kind":null,
              "company":null,
              "amount":0.0,
              "adjustments":[  
        
              ]
           },
           "result_messages":[  
        
           ],
           "result":"success",
           "reference":"SDK-4",
           "payments":[  
              {  
                 "status":"authorized",
                 "result_messages":[  
        
                 ],
                 "result":"success",
                 "refundable_amount":200.0,
                 "reference":"",
                 "method":"billet",
                 "id":"7bc839c5-991a-40a1-bcad-012c47f384ac",
                 "billet":{  
                    "url":"fake-url",
                    "number":"12805826",
                    "download_url":"fake-download-url"
                 },
                 "amount":200.0
              }
           ],
           "fingerprint":"fake-fingerprint",
           "commissionings":[  
        
           ],
           "charge_uuid":"fake-charge-uuid"
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
            "Sum of payments amount doesnt match with amount"
          ],
          "result_code": {
            "message": [
              "Sum of payments amount doesnt match with amount"
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
