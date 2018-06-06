<?php
//Replace the line with require "vendor/autoload.php" if you are using the Samples from outside of _Samples folder
include('../config.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;

session_start();
$dataService = DataService::Configure(array(
  'auth_mode' => 'oauth2',
  'ClientID' => "Q0z9mSa2LjMhVPiBKh41jj8dsJv3Q20mns1KM2mPWY1Z71W9uS",
  'ClientSecret' => "k7Fq32vy1mY7tCoNkyYpVM9pA1Yx0AZjBN3SNIHU",
  'RedirectURI' => "http://localhost/quickbooks/src/_Samples/Teste.php",
  'scope' => "com.intuit.quickbooks.accounting",
  'baseUrl' => "development"
));


$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

//It will return something like:https://b200efd8.ngrok.io/OAuth2_c/OAuth_2/OAuth2PHPExample.php?state=RandomState&code=Q0115106996168Bqap6xVrWS65f2iXDpsePOvB99moLCdcUwHq&realmId=193514538214074
//get the Code and realmID, use for the exchangeAuthorizationCodeForToken
$accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($_SESSION['code'], $_SESSION['realmId']);

/*
 *
 *
 *
 *
 *
 *
 *
 * Enviando Invoice
 *
 *
 *
 *
 *
 *
 *
 *
 * */

$dataService = DataService::Configure(array(
    'auth_mode' => 'oauth2',
    'ClientID' => "Q0z9mSa2LjMhVPiBKh41jj8dsJv3Q20mns1KM2mPWY1Z71W9uS",
    'ClientSecret' => "k7Fq32vy1mY7tCoNkyYpVM9pA1Yx0AZjBN3SNIHU",
    'accessTokenKey' =>  (string)$accessToken->getAccessToken(),
    'refreshTokenKey' => (string)$accessToken->getRefreshToken(),
    'QBORealmID' => $_SESSION['realmId'],
    'baseUrl' => "development"
));

$dataService->throwExceptionOnError(true);


/*$json = '{
  "Line": [
    {
      "Amount": 777.77,
      "DetailType": "SalesItemLineDetail",
      "SalesItemLineDetail": {
        "ItemRef": {
          "value": "1",
          "name": "Services"
        }
      }
    }
  ],
  "CustomerRef": {
    "value": "1"
  }
}';
$result = json_decode ($json, true);
$theResourceObj = Invoice::create($result);*/


$theResourceObj = Invoice::create([
    "Line" => [
        [
            "Amount" => 999.99,
            "DetailType" => "SalesItemLineDetail",
            "SalesItemLineDetail" => [
                "ItemRef" => [
                    "value" => 1,
                    "name" => "Services"
                ],
                "ItemRef" => [
                    "value" => 2,
                    "name" => "Concrete"
                ]
            ]
        ]
    ],
    "CustomerRef"=> [
        "value"=> 1
    ],
    "BillEmail" => [
        "Address" => "josueprg@gmail.com"
    ],
    "BillEmailCc" => [
        "Address" => "a@intuit.com"
    ],
    "BillEmailBcc" => [
        "Address" => "josueprg@gmail.com"
    ]
]);


$resultingObj = $dataService->Add($theResourceObj);

$error = $dataService->getLastError();
if ($error) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
}
else {
    echo "<pre>";
    var_dump($resultingObj->DocNumber);
    echo "</pre>";

    echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
    $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
    echo "<pre>";
    echo $xmlBody . "\n";
    echo "</pre>";
}
