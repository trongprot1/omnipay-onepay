<?php
namespace Omnipay\OnePay;

use Omnipay\Common\AbstractGateway as BaseAbstractGateway;

/**
 * Class AbstractGateway
 * @package Omnipay\OnePay;
 */
abstract class AbstractGateway extends BaseAbstractGateway
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'OnePay Gateway';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'vpcAccessCode' => '',
            'vpcMerchant' => '',
            'secureHash' => '',
            'vpcUser' => '',
            'vpcPassword' => '',
            'testMode' => false,
        ];
    }

    /**
     * @param $vpcPromotionList
     * @return OnePayGateway
     */
    public function setVpcPromotionList($vpcPromotionList)
    {
        return $this->setParameter('vpcPromotionList', $vpcPromotionList);
    }

    /**
     * @return mixed
     */
    public function getVpcPromotionList()
    {
        return $this->getParameter('vpcPromotionList');
    }

    /**
     * @param $vpcPromotionAmountList
     * @return OnePayGateway
     */
    public function setVpcPromotionAmountList($vpcPromotionAmountList)
    {
        return $this->setParameter('vpcPromotionAmountList', $vpcPromotionAmountList);
    }

    /**
     * @return mixed
     */
    public function getVpcPromotionAmountList()
    {
        return $this->getParameter('vpcPromotionAmountList');
    }

    /**
     * @return mixed
     */
    public function getVpcAccessCode()
    {
        return $this->getParameter('vpcAccessCode');
    }


    /**
     * @param $vpcAccessCode
     * @return OnePayGateway
     */
    public function setVpcAccessCode($vpcAccessCode)
    {
        return $this->setParameter('vpcAccessCode', $vpcAccessCode);
    }


    /**
     * @return mixed
     */
    public function getVpcMerchant()
    {
        return $this->getParameter('vpcMerchant');
    }


    /**
     * @param $vpcMerchant
     * @return OnePayGateway
     */
    public function setVpcMerchant($vpcMerchant)
    {
        return $this->setParameter('vpcMerchant', $vpcMerchant);
    }


    /**
     * @return mixed
     */
    public function getSecureHash()
    {
        return $this->getParameter('secureHash');
    }


    /**
     * @param $secureHash
     * @return OnePayGateway
     */
    public function setSecureHash($secureHash)
    {
        return $this->setParameter('secureHash', $secureHash);
    }


    /**
     * @return mixed
     */
    public function getVpcUser()
    {
        return $this->getParameter('vpcUser');
    }


    /**
     * @param $vpcUser
     * @return OnePayGateway
     */
    public function setVpcUser($vpcUser)
    {
        return $this->setParameter('vpcUser', $vpcUser);
    }


    /**
     * @return mixed
     */
    public function getVpcPassword()
    {
        return $this->getParameter('vpcPassword');
    }


    /**
     * @param $vpcPassword
     * @return OnePayGateway
     */
    public function setVpcPassword($vpcPassword)
    {
        return $this->setParameter('vpcPassword', $vpcPassword);
    }


    /**
     * @return bool|mixed
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }


    /**
     * @param bool $value
     * @return OnePayGateway
     */
    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\OnePay\Message\PurchaseRequest', $parameters);
    }


    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\OnePay\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * TODO should move to AbstractGateway
     *
     * Create a response object using existing parameters from return url , redirect url
     *
     * @param string $class The response class name, ex: \Omnipay\Payflow\Message\Response
     * @param array $parameters , ex: ["action" => "return", "vpc_TxnResponseCode" => 5, "vpc_Message" => "Amount is
     *                           invalid"]
     *
     * @return object, ex: \Omnipay\Common\Message\Response
     */
    public function createResponse($class, array $parameters, $type)
    {
        return new $class(call_user_func_array([$this, $type], [$parameters]), $parameters);
    }

    /**
     * @param array $parameters
     * @param string $type
     * @return object
     */
    public function getResponse(array $parameters = [], $type = 'purchase')
    {
        return $this->createResponse('\Omnipay\OnePay\Message\Response', $parameters, $type);
    }
}
