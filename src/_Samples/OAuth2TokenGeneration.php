<?php
//Replace the line with require "vendor/autoload.php" if you are using the Samples from outside of _Samples folder
include('../config.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;


$dataService = DataService::Configure(array(
  'auth_mode' => 'oauth2',
  'ClientID' => "Q0z9mSa2LjMhVPiBKh41jj8dsJv3Q20mns1KM2mPWY1Z71W9uS",
  'ClientSecret' => "k7Fq32vy1mY7tCoNkyYpVM9pA1Yx0AZjBN3SNIHU",
  'RedirectURI' => "http://localhost/quickbooks/src/_Samples/Teste.php",
  'scope' => "com.intuit.quickbooks.accounting",
  'baseUrl' => "development"
));


$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

$url = $OAuth2LoginHelper->getAuthorizationCodeURL();

header("Location: $url");


//It will return something like:https://b200efd8.ngrok.io/OAuth2_c/OAuth_2/OAuth2PHPExample.php?state=RandomState&code=Q0115106996168Bqap6xVrWS65f2iXDpsePOvB99moLCdcUwHq&realmId=193514538214074
//get the Code and realmID, use for the exchangeAuthorizationCodeForToken
$accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken("Q01152829543905ozO9T6JnJEHF1pFvOHlk5H1bwRmidSPDvzj", "123146079694899");
echo "<pre>";
var_dump($accessToken);
echo "</pre>";
exit();

$dataService->updateOAuth2Token($accessToken);
$dataService->throwExceptionOnError(true);

$CompanyInfo = $dataService->getCompanyInfo();
$nameOfCompany = $CompanyInfo->CompanyName;
echo "Test for OAuth Complete. Company Name is {$nameOfCompany}. Returned response body:\n\n";
$xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($CompanyInfo, $somevalue);
echo $xmlBody . "\n";

//$result = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken("Q0115103503429HrpsLMzMwNXyd3phqSFStBXsUsEPffiPlvzQ");

/*
$error = $OAuth2LoginHelper->getLastError();
if ($error != null) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
    return;
}

$CompanyInfo = $dataService->getCompanyInfo();
$error = $dataService->getLastError();
if ($error != null) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
} else {
    $nameOfCompany = $CompanyInfo->CompanyName;
    echo "Test for OAuth Complete. Company Name is {$nameOfCompany}. Returned response body:\n\n";
    $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($CompanyInfo, $somevalue);
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
