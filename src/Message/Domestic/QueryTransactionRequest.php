<?php
/**
 * @link https://github.com/phpviet/omnipay-onepay
 *
 * @copyright (c) PHP Viet
 * @license [MIT](https://opensource.org/licenses/MIT)
 */

namespace Omnipay\OnePay\Message\Domestic;

use Omnipay\OnePay\Message\AbstractQueryTransactionRequest;

/**
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0.0
 */
class QueryTransactionRequest extends AbstractQueryTransactionRequest
{
    protected $testEndpoint = 'https://mtf.onepay.vn/msp/api/v1/vpc/invoices/queries';

    protected $productionEndpoint = 'https://onepay.vn/msp/api/v1/vpc/invoices/queries';
}
