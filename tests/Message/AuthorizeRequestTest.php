<?php

namespace Omnipay\Dummy\Message;

use Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'amount' => '10.00',
        ]);
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('10.00', $data['amount']);
    }
}
