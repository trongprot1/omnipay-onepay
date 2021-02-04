<?php
/**
 * OnePay Abstract Request
 */

namespace Omnipay\OnePay\Message;

use \Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Class AbstractRequest
 * @package Omnipay\OnePay\Message
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     *
     */
    const API_VERSION = '2';

    /**
     * @var string
     */
    protected $liveEndpoint = 'https://mtf.onepay.vn/paygate/vpcpay.op';

    /**
     * @var string
     */
    protected $testEndpoint = 'https://mtf.onepay.vn/paygate/vpc.op';

    /**
     * @return mixed
     */
    abstract protected function getEndpoint();

    /**
     * @param $vpcPromotionList
     * @return AbstractRequest
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
     * @return AbstractRequest
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
     * @return float|int
     */
    public function getAmountInteger()
    {
        $result = parent::getAmountInteger();

        if ('VND' == strtoupper($this->getCurrency())) {
            return $result * 100;
        }

        return $result;
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
     * @return AbstractRequest
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
     * @return AbstractRequest
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
     * @return AbstractRequest
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
     * @return AbstractRequest
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
     * @return AbstractRequest
     */
    public function setVpcPassword($vpcPassword)
    {
        return $this->setParameter('vpcPassword', $vpcPassword);
    }

    /**
     * @return string
     */
    public function getVpc_MerchTxnRef()
    {
        return $this->getTransactionId();
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setVpc_MerchTxnRef($value)
    {
        return $this->setParameter('vpc_MerchTxnRef', $value);
    }

    /**
     * @return array
     */
    protected function getBaseData()
    {
        return [
            'vpc_Merchant' => $this->getVpcMerchant(),
            'vpc_AccessCode' => $this->getVpcAccessCode(),
        ];
    }

    /**
     * @param mixed $data
     * @return \Omnipay\Common\Message\ResponseInterface|Response
     */
    public function sendData($data)
    {
        $url = $this->getEndpoint() . '?' . http_build_query($data, '', '&');
        $httpResponse = $this->httpClient->get($url)->send();
        return $this->createResponse($httpResponse->getBody());
    }

    /**
     * @param $data
     * @return Response
     */
    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function generateDataWithChecksum($data)
    {
        ksort($data);

        unset($data["virtualPaymentClientURL"]);
        unset($data["SubButL"]);
        unset($data["vpc_order_id"]);

        $stringHashData = "";

        foreach ($data as $key => $value) {
            if (strlen($value) > 0) {
                if ((strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0,
                                5) == "user_"))
                ) {
                    $stringHashData .= $key . "=" . $value . "&";
                }
            }
        }

        $stringHashData = rtrim($stringHashData, "&");
        $data['vpc_SecureHash'] = strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $this->getSecureHash())));

        return $data;
    }
}
