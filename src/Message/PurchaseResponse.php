<?php
namespace Omnipay\OnePay\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class PurchaseResponse
 * @package Omnipay\OnePay\Message
 */
class PurchaseResponse extends Response implements RedirectResponseInterface
{

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }


    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->getCheckoutEndpoint() . '?' . http_build_query($this->data, '', '&');
    }


    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }


    /**
     * @return null
     */
    public function getRedirectData()
    {
        return null;
    }


    /**
     * @return mixed
     */
    protected function getCheckoutEndpoint()
    {
        return $this->getRequest()->getEndpoint();
    }
}
