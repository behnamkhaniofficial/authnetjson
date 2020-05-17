<?php
/*************************************************************************************************

Use the CIM JSON API to process a Capture Only transaction

SAMPLE REQUEST
--------------------------------------------------------------------------------------------------
{
   "createCustomerProfileTransactionRequest":{
      "merchantAuthentication":{
         "name":"",
         "transactionKey":""
      },
      "transaction":{
         "profileTransCaptureOnly":{
            "amount":"10.95",
            "tax":{
               "amount":"1.00",
               "name":"WA state sales tax",
               "description":"Washington state sales tax"
            },
            "shipping":{
               "amount":"2.00",
               "name":"ground based shipping",
               "description":"Ground based 5 to 10 day shipping"
            },
            "lineItems":[
               {
                  "itemId":"1",
                  "name":"vase",
                  "description":"Cannes logo",
                  "quantity":"18",
                  "unitPrice":"45.00"
               },
               {
                  "itemId":"2",
                  "name":"desk",
                  "description":"Big Desk",
                  "quantity":"10",
                  "unitPrice":"85.00"
               }
            ],
            "customerProfileId":"31390172",
            "customerPaymentProfileId":"28393490",
            "customerShippingAddressId":"29366174",
            "order":{
               "invoiceNumber":"INV000001",
               "description":"description of transaction",
               "purchaseOrderNumber":"PONUM000001"
            },
            "taxExempt":"false",
            "recurringBilling":"false",
            "cardCode":"000",
            "approvalCode":"000000"
         }
      },
      "extraOptions":"x_customer_ip=100.0.0.1"
   }
}

SAMPLE RESPONSE
--------------------------------------------------------------------------------------------------
{
   "directResponse":"1,1,1,This transaction has been approved.,000000,P,2230582335,INV000001,description of transaction,10.95,CC,capture_only,12345,John,Smith,,123 Main Street,Townsville,NJ,12345,,800-555-1234,,user@example.com,John,Smith,,123 Main Street,Townsville,NJ,12345,,1.00,,2.00,FALSE,PONUM000001,0DAC5007786DEA5A5EB02C0C56A68F87,,,,,,,,,,,,,XXXX1111,Visa,,,,,,,,,,,,,,,,,29366174",
   "messages":{
      "resultCode":"Ok",
      "message":[
         {
            "code":"I00001",
            "text":"Successful."
         }
      ]
   }
}

*************************************************************************************************/

namespace JohnConde\Authnet;

use Exception;

require '../../config.inc.php';

try {
    $request = AuthnetApiFactory::getJsonApiHandler(
        AUTHNET_LOGIN,
        AUTHNET_TRANSKEY,
        AuthnetApiFactory::USE_DEVELOPMENT_SERVER
    );
    $response = $request->createCustomerProfileTransactionRequest([
        'transaction' => [
            'profileTransCaptureOnly' => [
                'amount' => '10.95',
                'tax' => [
                    'amount' => '1.00',
                    'name' => 'WA state sales tax',
                    'description' => 'Washington state sales tax'
                ],
                'shipping' => [
                    'amount' => '2.00',
                    'name' => 'ground based shipping',
                    'description' => 'Ground based 5 to 10 day shipping'
                ],
                'lineItems' => [
                    [
                        'itemId' => '1',
                        'name' => 'vase',
                        'description' => 'Cannes logo',
                        'quantity' => '18',
                        'unitPrice' => '45.00'
                    ],
                    [
                        'itemId' => '2',
                        'name' => 'desk',
                        'description' => 'Big Desk',
                        'quantity' => '10',
                        'unitPrice' => '85.00'
                    ]
                ],
                'customerProfileId' => '31390172',
                'customerPaymentProfileId' => '28393490',
                'customerShippingAddressId' => '29366174',
                'order' => [
                    'invoiceNumber' => 'INV000001',
                    'description' => 'description of transaction',
                    'purchaseOrderNumber' => 'PONUM000001'
                ],
                'taxExempt' => 'false',
                'recurringBilling' => 'false',
                'cardCode' => '000',
                'approvalCode' => '000000'
            ]
        ],
        'extraOptions' => 'x_customer_ip=100.0.0.1'
    ]);
} catch (Exception $e) {
    echo $e;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CIM :: Capture Only</title>
    <style type="text/css">
        table { border: 1px solid #cccccc; margin: auto; border-collapse: collapse; max-width: 90%; }
        table td { padding: 3px 5px; vertical-align: top; border-top: 1px solid #cccccc; }
        pre { white-space: pre-wrap; }
        table th { background: #e5e5e5; color: #666666; }
        h1, h2 { text-align: center; }
    </style>
</head>
<body>
    <h1>
        CIM :: Capture Only
    </h1>
    <h2>
        Results
    </h2>
    <table>
        <tr>
            <th>Response</th>
            <td><?= $response->messages->resultCode ?></td>
        </tr>
        <tr>
            <th>code</th>
            <td><?= $response->messages->message[0]->code ?></td>
        </tr>
        <tr>
            <th>Successful?</th>
            <td><?= $response->isSuccessful() ? 'yes' : 'no' ?></td>
        </tr>
        <tr>
            <th>Error?</th>
            <td><?= $response->isError() ? 'yes' : 'no' ?></td>
        </tr>
    </table>
    <h2>
        Raw Input/Output
    </h2>
<?= $request, $response ?>
</body>
</html>
