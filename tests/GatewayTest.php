<?php

namespace Omnipay\Saferpay;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();
        // var_dump($this->getHttpClient());
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = [
            'amount' => '61.99',
            'currency' => 'CHF',
            'transactionId' => '2',
            'terminalId' => 'nothing',
            'customerId' => 'nothing',
            'returnUrl' => 'http://example.com/success',
            'cancelUrl' => 'http://example.com/cancel',
            'testMode' => true,
            'description' => 'Description of Payment',
        ];
    }

    public function testAuthorizeSuccess()
    {
        $request = $this->gateway->authorize($this->options);
        $this->assertInstanceOf('\Omnipay\Saferpay\Message\AuthorizeRequest', $request);
        $this->assertEquals(['Amount' => ['Value' => 6199, 'CurrencyCode' => 'CHF'], 'OrderId' => '2', 'Description' => 'Description of Payment'], $request->getData()['Payment']);
    }
}
