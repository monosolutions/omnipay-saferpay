<?php

namespace Omnipay\Saferpay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Saferpay';
    }

    public function getDefaultParameters()
    {
        return [];
    }

    /**
     * Create an authorize request.
     *
     * @param array $parameters
     * @return \Omnipay\Saferpay\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Saferpay\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Create an authorize request.
     *
     * @param array $parameters
     * @return \Omnipay\Saferpay\Message\CaptureRequest
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Saferpay\Message\CaptureRequest', $parameters);
    }

    /**
     * Create a purchase request.
     *
     * @param array $parameters
     * @return \Omnipay\Saferpay\Message\AuthorizeRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->authorize($parameters);
    }
}
