<?php
namespace Rakuten\Tests\Unit\Service\Http;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Resource\RakutenConnector;

class RakutenConnectorTest extends TestCase
{
    public function testIfShouldGettersAndSetters()
    {
        $apiKey = "fake-apikey";
        $signature = "fake-signature";
        $environment = "fake-environment";
        $document = "fake-document";

        $rakuten = new RakutenConnector($document, $apiKey, $signature, $environment);

        $this->assertEquals($apiKey, $rakuten->getApiKey());
        $this->assertEquals($signature, $rakuten->getSignature());
        $this->assertEquals($environment, $rakuten->getEnvironment());
        $this->assertEquals($document, $rakuten->getDocument());
    }
}
