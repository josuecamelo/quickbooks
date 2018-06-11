<?php
//Replace the line with require "vendor/autoload.php" if you are using the Samples from outside of _Samples folder
include('../config.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Item;


session_start();
$dataService = DataService::Configure(array(
    'auth_mode' => 'oauth2',
    'ClientID' => "Q0z9mSa2LjMhVPiBKh41jj8dsJv3Q20mns1KM2mPWY1Z71W9uS",
    'ClientSecret' => "k7Fq32vy1mY7tCoNkyYpVM9pA1Yx0AZjBN3SNIHU",
    'RedirectURI' => "http://localhost/quickbooks/src/_Samples/Teste.php",
    'scope' => "com.intuit.quickbooks.accounting",
    'baseUrl' => "development"
));

//$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");

$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

//It will return something like:https://b200efd8.ngrok.io/OAuth2_c/OAuth_2/OAuth2PHPExample.php?state=RandomState&code=Q0115106996168Bqap6xVrWS65f2iXDpsePOvB99moLCdcUwHq&realmId=193514538214074
//get the Code and realmID, use for the exchangeAuthorizationCodeForToken
$accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($_SESSION['code'], $_SESSION['realmId']);



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




$dateTime = new \DateTime('NOW');
$Item = Item::create([
      "Name" => "Serviço do Pessoal Brasileiro",
      "Description" => "System Evolution",
      "Active" => true,
      "FullyQualifiedName" => "Desenvolvimento Web",
      "Taxable" => true,
      "UnitPrice" => 25,
      "Type" => "Service",
      "IncomeAccountRef"=> [
        "value"=> 79,
        "name" => "Landscaping Services:Job Materials:Fountains and Garden Lighting"
      ],
      "PurchaseDesc"=> "This is the purchasing description.",
      "PurchaseCost"=> 35,
      "ExpenseAccountRef"=> [
        "value"=> 80,
        "name"=> "Cost of Goods Sold"
      ],
      "AssetAccountRef"=> [
        "value"=> 81,
        "name"=> "Inventory Asset"
      ],
      /*"TrackQtyOnHand" => true,
      "QtyOnHand"=> 100,
      "InvStartDate"=> $dateTime*/
]);


$resultingObj = $dataService->Add($Item);
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

Example output:

Account[0]: Travel Meals
     * Id: NG:42315
     * AccountType: Expense
     * AccountSubType:

Account[1]: COGs
     * Id: NG:40450
     * AccountType: Cost of Goods Sold
     * AccountSubType:

...

*/
 ?>
