<?php

/*
 * This file is part of the AuthnetJSON package.
 *
 * (c) John Conde <stymiee@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
/*************************************************************************************************

Use the ARB API to create get a subscription's status

SAMPLE REQUEST
--------------------------------------------------------------------------------------------------
{  
   "ARBGetSubscriptionStatusRequest":{  
      "merchantAuthentication":{  
         "name":"",
         "transactionKey":""
      },
      "refId":"Sample",
      "subscriptionId":"1207505"
   }
}

SAMPLE RESPONSE
--------------------------------------------------------------------------------------------------
{  
   "note":"Status with a capital 'S' is obsolete.",
   "status":"canceled",
   "Status":"canceled",
   "statusSpecified":true,
   "StatusSpecified":true,
   "refId":"Sample",
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

    require('../../config.inc.php');
    require('../../src/autoload.php');

    $json = AuthnetApiFactory::getJsonApiHandler(AUTHNET_LOGIN, AUTHNET_TRANSKEY, AuthnetApiFactory::USE_DEVELOPMENT_SERVER);
    $json->ARBGetSubscriptionStatusRequest(array(
        'refId' => 'Sample',
        'subscriptionId' => '1207505'
    ));
?>

<!DOCTYPE html>
<html>
<html lang="en">
    <head>
        <title></title>
        <style type="text/css">
            table
            {
                border: 1px solid #cccccc;
                margin: auto;
                border-collapse: collapse;
                max-width: 90%;
            }

            table td
            {
                padding: 3px 5px;
                vertical-align: top;
                border-top: 1px solid #cccccc;
            }

            pre
            {
            	overflow-x: auto; /* Use horizontal scroller if needed; for Firefox 2, not needed in Firefox 3 */
            	white-space: pre-wrap; /* css-3 */
            	white-space: -moz-pre-wrap !important; /* Mozilla, since 1999 */
            	white-space: -pre-wrap; /* Opera 4-6 */
            	white-space: -o-pre-wrap; /* Opera 7 */ /*
            	width: 99%; */
            	word-wrap: break-word; /* Internet Explorer 5.5+ */
            }

            table th
            {
                background: #e5e5e5;
                color: #666666;
            }

            h1, h2
            {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h1>
            ARB :: Get Subscription Status
        </h1>
        <h2>
            Results
        </h2>
        <table>
            <tr>
                <th>Response</th>
                <td><?php echo $json->messages->resultCode; ?></td>
            </tr>
            <tr>
                <th>code</th>
                <td><?php echo $json->messages->message[0]->code; ?></td>
            </tr>
            <tr>
                <th>Successful?</th>
                <td><?php echo ($json->isSuccessful()) ? 'yes' : 'no'; ?></td>
            </tr>
            <tr>
                <th>Error?</th>
                <td><?php echo ($json->isError()) ? 'yes' : 'no'; ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo $json->status; ?></td>
            </tr>
        </table>
        <h2>
            Raw Input/Output
        </h2>
<?php
    echo $json;
?>
    </body>
</html>
