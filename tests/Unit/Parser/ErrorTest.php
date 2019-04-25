<?php
namespace Rakuten\Tests\Unit\Parser;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\Error;

class ErrorTest extends TestCase
{
    public function testMethodsGettersAndSetters()
    {
        $code = "123";
        $message = "Sum of payments amount doesn't match with amount";

        $error = new Error();

        $error->setCode($code)
            ->setMessage($message);

        $this->assertEquals($code, $error->getCode(), "Return Code from error");
        $this->assertEquals($message, $error->getMessage(), "Return Message from error");
    }
}