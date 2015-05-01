<?php

/*
 * This file is part of the AuthnetJSON package.
 *
 * (c) John Conde <stymiee@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JohnConde\Authnet;

/**
 * Adapter for the Authorize.Net JSON API
 *
 * @package     AuthnetJSON
 * @author      John Conde <stymiee@gmail.com>
 * @copyright   John Conde <stymiee@gmail.com>
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache License, Version 2.0
 * @link        https://github.com/stymiee/authnetjson
 * @see         https://developer.authorize.net/api/reference/
 *
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createTransactionRequest(array $array)                                 process a payment
 * @method      \JohnConde\Authnet\AuthnetJsonResponse sendCustomerTransactionReceiptRequest(array $array)                    get a list of unsettled transactions
 * @method      \JohnConde\Authnet\AuthnetJsonResponse ARBCancelSubscriptionRequest(array $array)                             cancel a subscription
 * @method      \JohnConde\Authnet\AuthnetJsonResponse ARBCreateSubscriptionRequest(array $array)                             create a subscription
 * @method      \JohnConde\Authnet\AuthnetJsonResponse ARBGetSubscriptionStatusRequest(array $array)                          get a subscription's status
 * @method      \JohnConde\Authnet\AuthnetJsonResponse ARBUpdateSubscriptionRequest(array $array)                             update a subscription
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createCustomerPaymentProfileRequest(array $array)                      create a payment profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createCustomerProfileRequest(array $array)                             create a customer profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createCustomerProfileTransactionRequest_authCapture(array $array)      process an Authorization and Capture transaction (Sale)
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createCustomerProfileTransactionRequest_authOnly(array $array)         process an Authorization Only transaction
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createCustomerProfileTransactionRequest_captureOnly(array $array)      process a Capture Only transaction
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createCustomerProfileTransactionRequest_priorAuthCapture(array $array) process a Prior Authorization Capture transaction
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createCustomerProfileTransactionRequest_refund(array $array)           process a Refund (credit)
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createCustomerProfileTransactionRequest_void(array $array)             void a transaction
 * @method      \JohnConde\Authnet\AuthnetJsonResponse createCustomerShippingAddressRequest(array $array)                     create a shipping profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse deleteCustomerPaymentProfileRequest(array $array)                      delete a payment profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse deleteCustomerProfileRequest(array $array)                             delete a customer profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse deleteCustomerShippingAddressRequest(array $array)                     delete a shipping profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getCustomerPaymentProfileRequest(array $array)                         retrieve a payment profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getCustomerProfileIdsRequest(array $array)                             retrieve a list of profile IDs
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getCustomerProfileRequest(array $array)                                retrieve a customer profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getCustomerShippingAddressRequest(array $array)                        retrieve a shipping address
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getHostedProfilePageRequest(array $array)                              retrieve a hosted payment page token
 * @method      \JohnConde\Authnet\AuthnetJsonResponse updateCustomerPaymentProfileRequest(array $array)                      update a customer profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse updateCustomerProfileRequest(array $array)                             update a customer profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse updateCustomerShippingAddressRequest(array $array)                     update a shipping address
 * @method      \JohnConde\Authnet\AuthnetJsonResponse updateSplitTenderGroupRequest(array $array)                            update a split tender transaction
 * @method      \JohnConde\Authnet\AuthnetJsonResponse validateCustomerPaymentProfileRequest(array $array)                    validate a payment profile
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getBatchStatisticsRequest(array $array)                                get a summary of a settled batch
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getSettledBatchListRequest(array $array)                               get a list of settled batches
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getTransactionDetailsRequest(array $array)                             get the details of a transaction
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getTransactionListRequest(array $array)                                get a list of transaction in a batch
 * @method      \JohnConde\Authnet\AuthnetJsonResponse getUnsettledTransactionListRequest(array $array)                       get a list of unsettled transactions
 */
class AuthnetJsonRequest
{
    /**
     * @var     string  Authorize.Net API login ID
     */
    private $login;

    /**
     * @var     string  Authorize.Net API Transaction Key
     */
    private $transactionKey;

    /**
     * @var     string  URL endpoint for processing a transaction
     */
    private $url;

    /**
     * @var     string  JSON formatted API request
     */
    private $responseJson;

    /**
     * @var     object  Wrapper object repsenting an endpoint
     */
    private $processor;

    /**
     * @param   string  $login              Authorize.Net API login ID
     * @param   string  $transactionKey     Authorize.Net API Transaction Key
     * @param   string  $api_url            URL endpoint for processing a transaction
     */
	public function __construct($login, $transactionKey, $api_url)
	{
		$this->login          = $login;
        $this->transactionKey = $transactionKey;
        $this->url            = $api_url;
	}

    /**
     * @return  string  HTML table containing debugging information
     */
	public function __toString()
	{
	    $output  = '';
        $output .= '<table summary="Authorize.Net Request" id="authnet-request">' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<th colspan="2"><b>Class Parameters</b></th>' . "\n" . '</tr>' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<td><b>API Login ID</b></td><td>' . $this->login . '</td>' . "\n" . '</tr>' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<td><b>Transaction Key</b></td><td>' . $this->transactionKey . '</td>' . "\n" . '</tr>' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<td><b>Authnet Server URL</b></td><td>' . $this->url . '</td>' . "\n" . '</tr>' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<th colspan="2"><b>Request JSON</b></th>' . "\n" . '</tr>' . "\n";
        if (!empty($this->responseJson)) {
            $output .= '<tr><td colspan="2"><pre>' . "\n";
            $output .= $this->responseJson . "\n";
            $output .= '</pre></td></tr>' . "\n";
        }
        $output .= '</table>';

        return $output;
	}

    /**
     * @throws  \JohnConde\Authnet\AuthnetCannotSetParamsException
     */
    public function __set($key, $value)
	{
        throw new AuthnetCannotSetParamsException('You cannot set parameters directly in ' . __CLASS__ . '.');
	}

    /**
     * @returns null
     */
    public function __call($api_call, $args)
	{
        $authentication = array(
            'merchantAuthentication' => array(
                'name'           => $this->login,
                'transactionKey' => $this->transactionKey,
            )
        );
        $call = array();
        if (count($args)) {
            $call = $args[0];
        }
        $parameters = array(
            $api_call => $authentication + $call
        );
        $this->responseJson = json_encode($parameters);

		$response = $this->process();
        return new AuthnetJsonResponse($response);
	}

    /**
     * @throws  \JohnConde\Authnet\AuthnetInvalidJsonException
     */
    private function process()
    {
        return $this->processor->process($this->url, $this->responseJson);
    }

    /**
     * @param   object  $processor
     */
    public function setProcessHandler($processor)
    {
        $this->processor = $processor;
    }
}