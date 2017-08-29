<?php

namespace Omnipay\Saferpay\Message;

/**
 * Dummy Authorize Request
 *
 * ### Example
 *
 * <code>
 * // Create a gateway for the Dummy Gateway
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Dummy');
 *
 * // Initialise the gateway
 * $gateway->initialize(array(
 *     'testMode' => true, // Doesn't really matter what you use here.
 * ));
 *
 * // Create a credit card object
 * // This card can be used for testing.
 * $card = new CreditCard(array(
 *             'firstName'    => 'Example',
 *             'lastName'     => 'Customer',
 *             'number'       => '4242424242424242',
 *             'expiryMonth'  => '01',
 *             'expiryYear'   => '2020',
 *             'cvv'          => '123',
 * ));
 *
 * // Do an authorize transaction on the gateway
 * $transaction = $gateway->authorize(array(
 *     'amount'                   => '10.00',
 *     'currency'                 => 'AUD',
 *     'card'                     => $card,
 * ));
 * $response = $transaction->send();
 * if ($response->isSuccessful()) {
 *     echo "Authorize transaction was successful!\n";
 *     $sale_id = $response->getTransactionReference();
 *     echo "Transaction reference = " . $sale_id . "\n";
 * }
 * </code>
 */
class AuthorizeRequest extends AbstractRequest
{
    protected $endpoint = '/Payment/v1/PaymentPage/Initialize';

    public function setTerminalId($terminalId)
    {
        $this->setParameter('terminalId', $terminalId);
    }

    public function getTerminalId()
    {
        return $this->getParameter('terminalId');
    }

    public function setCustomerId($customerId)
    {
        $this->setParameter('customerId', $customerId);
    }

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setDescription($description)
    {
        $this->setParameter('description', $description);
    }
    public function getDescription()
    {
        return $this->getParameter('description');
    }

    public function getData()
    {
        $this->validate('amount', 'currency', 'transactionId', 'terminalId', 'customerId', 'returnUrl', 'cancelUrl');

        $requestData = [
            "RequestHeader" => [
                "SpecVersion" => "1.7",
                "CustomerId" => $this->getCustomerId(),
                "RequestId" => uniqid(),
                "RetryIndicator" => 0,
            ],
            "TerminalId" => $this->getTerminalId(),
            "Payment" => [
                "Amount" => [
                    "Value" => $this->getAmountInteger(),
                    "CurrencyCode" => $this->getCurrency(),
                ],
                "OrderId" => $this->getTransactionId(),
                "Description" => $this->getDescription(),
            ],
            "ReturnUrls" => [
                "Success" => $this->getReturnUrl(),
                "Fail" => $this->getCancelUrl(),
            ],
        ];

        return $requestData;
    }

    public function sendData($data)
    {
        return $this->sendRequest($this->endpoint, $data);
    }

    public function createResponse($response)
    {
        return new AuthorizeResponse($this, $response);
    }
}
