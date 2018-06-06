<?php
//Replace the line with require "vendor/autoload.php" if you are using the Samples from outside of _Samples folder
include('../config.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;

// Prep Data Services
/*$dataService = DataService::Configure(array(
       'auth_mode' => 'oauth1',
         'consumerKey' => "qyprdUSoVpIHrtBp0eDMTHGz8UXuSz",
         'consumerSecret' => "TKKBfdlU1I1GEqB9P3AZlybdC8YxW5qFSbuShkG7",
         'accessTokenKey' => "qyprdxccscoNl7KRbUJoaJQIhUvyXRzD9tNOlXn4DhRDoj4g",
         'accessTokenSecret' => "JqkHSBKzNHbqjMq0Njbcq8fjgJSpfjMvqHVWnDOW",
         'QBORealmID' => "193514464689044",
         'baseUrl' => "Development"
));
$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");*/

$dataService = DataService::Configure(array(
    'auth_mode' => 'oauth2',
    'ClientID' => "Q0fXL014zAv3wzmlhwXMEHTrKepfAshCRjztEu58ZokzCD5T7D",
    'ClientSecret' => "stfnZfuSZUDay6cJSWtvQ9HkWiKFbcI9YuBTET5P",
    'accessTokenKey' =>  "eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..lmGChkCAJYTxucq_gspS8A.of6yijgWgpPQ744zAoQZHL3ePKpF8b9UrAX9BB7Pp94-52acJgvTLaiJwSpbxTHs1S-1ap3WokLxL44_dciUANbSeqLvn6gf_oSv3TSNT_Za4j72Pl6kR8-VAcmYqIB75VLTvXA65qrPYirKRxsdJLs-WzzIEab6n5rNJo2DzAgqUIkir__ltf3JBOLvaaz3Hp40KvZaVQG0cl2w60DfIs-fjZwhzJG5FKSorw-_TCg1xmxbJXC6bZBntbo-OwiL5yJ8_FAsPcNo2d-sONhltN7zBug6M_dJ8Ptj3GhOJh8V16LUC0BFvvTncWTyiRPG8yDcq1Ngm172aDIw5jlL5UzW0hS8GarOGGUjWIc4nO_Zvvn1NwP06-1cL7Mb7HNJ4CgG9EjotqLHK07DEegQO5NZTRRE3lQfjtndcb4g2EsQJrThy6d412DD9UIwK-mm8gIch3skATvnDskWkP_fegmaAvd40jSMptPVt4_ujy-55CmZHk46QwjCJTiiSrh6kid--QewudVC9Mz6y3nnjEfEWZpsFcuuU7omghu-Ds-aoW94pYrKLTWcDd56S4moT9VFcvJGK5Ew_5HT6eavNvFhcO376mdkeYGxFJ7o4-i-4vCv27H-3KH4147yAheSJ0dqvjNxyFTCfULKPm2kgjz8LpcIi2wxLpShG7wgoe9ldcYUQTyDZ8wME6qgUR95.xczznGp9u2s1likp8jOhaQ",
    'refreshTokenKey' => 'Q0115201062198zx1lpp6MpzcYOqWbwqbHVJGfy0ledlb6A9Z8',
    'QBORealmID' => "193514611894164",
    'baseUrl' => "development"
));

$dataService->throwExceptionOnError(true);

//Add a new Invoice
$theResourceObj = Invoice::create([
     "Line" => [
   [
     "Amount" => 100.00,
     "DetailType" => "SalesItemLineDetail",
     "SalesItemLineDetail" => [
       "ItemRef" => [
         "value" => 20,
         "name" => "Hours"
        ]
      ]
      ]
    ],
"CustomerRef"=> [
  "value"=> 59
],
      "BillEmail" => [
            "Address" => "Familiystore@intuit.com"
      ],
      "BillEmailCc" => [
            "Address" => "a@intuit.com"
      ],
      "BillEmailBcc" => [
            "Address" => "v@intuit.com"
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
    echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
    $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
    echo $xmlBody . "\n";
}

/*
Created Customer Id=801. Reconstructed response body:

<?xml version="1.0" encoding="UTF-8"?>
<ns0:Customer xmlns:ns0="http://schema.intuit.com/finance/v3">
  <ns0:Id>801</ns0:Id>
  <ns0:SyncToken>0</ns0:SyncToken>
  <ns0:MetaData>
    <ns0:CreateTime>2013-08-05T07:41:45-07:00</ns0:CreateTime>
    <ns0:LastUpdatedTime>2013-08-05T07:41:45-07:00</ns0:LastUpdatedTime>
  </ns0:MetaData>
  <ns0:GivenName>GivenName21574516</ns0:GivenName>
  <ns0:FullyQualifiedName>GivenName21574516</ns0:FullyQualifiedName>
  <ns0:CompanyName>CompanyName426009111</ns0:CompanyName>
  <ns0:DisplayName>GivenName21574516</ns0:DisplayName>
  <ns0:PrintOnCheckName>CompanyName426009111</ns0:PrintOnCheckName>
  <ns0:Active>true</ns0:Active>
  <ns0:Taxable>true</ns0:Taxable>
  <ns0:Job>false</ns0:Job>
  <ns0:BillWithParent>false</ns0:BillWithParent>
  <ns0:Balance>0</ns0:Balance>
  <ns0:BalanceWithJobs>0</ns0:BalanceWithJobs>
  <ns0:PreferredDeliveryMethod>Print</ns0:PreferredDeliveryMethod>
</ns0:Customer>
*/
