<?php
namespace Sts\Onepay\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->isHashMatch() && $this->data['vpc_TxnResponseCode'] == '0';
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        switch ($this->data['vpc_TxnResponseCode']) {
            case '0' :
                return 'Approved';
                break;
            case '1' :
                return 'Bank declined';
                break;
            case '3' :
                return 'Merchant not exist';
                break;
            case '4' :
                return 'Invalid access code';
                break;
            case '5' :
                return 'Invalid amount';
                break;
            case '6' :
                return 'Invalid currency code';
                break;
            case '7' :
                return 'Unspecified failure';
                break;
            case '8' :
                return 'Invalid card Number';
                break;
            case '9' :
                return 'Invalid card name';
                break;
            case '10' :
                return 'Expired card';
                break;
            case '11' :
                return 'Card not registered service(internet banking)';
                break;
            case '12' :
                return 'Invalid card date';
                break;
            case '13' :
                return 'Exist amount';
                break;
            case '21' :
                return 'Insufficient fund';
                break;
            case '99' :
                return 'User cancel';
                break;
            default :
                return 'Failed - ' . json_encode($this->data);
        }
    }

    /**
     * @return mixed|string|null
     */
    public function getTransactionReference()
    {
        if (isset($this->data['vpc_TransactionNo'])) {
            return $this->data['vpc_TransactionNo'];
        }

        return null;
    }

    /**
     * @return mixed|string|null
     */
    public function getTransactionId()
    {
        if (isset($this->data['vpc_OrderInfo'])) {
            return $this->data['vpc_OrderInfo'];
        }

        return null;
    }

    /**
     * @return bool
     */
    private function isHashMatch()
    {
        return (strtoupper($this->data['vpc_SecureHash']) == strtoupper($this->data['computed_hash_value']));
    }
}
