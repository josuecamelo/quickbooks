<?php
include('../config.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Data\IPPCustomer;

// Prep Data Services
$dataService = DataService::Configure(array(
       'auth_mode' => 'oauth1',
         'consumerKey' => "Q0z9mSa2LjMhVPiBKh41jj8dsJv3Q20mns1KM2mPWY1Z71W9uS",
         'consumerSecret' => "k7Fq32vy1mY7tCoNkyYpVM9pA1Yx0AZjBN3SNIHU",
         'accessTokenKey' => "qye2etcpyquO3B1t8ydZJI8OTelqJCMiLZlY5LdX7qZunwoo",
         'accessTokenSecret' => "2lEUtSEIvXf64CEkMLaGDK5rCwaxE9UvfW1dYrrH",
         'QBORealmID' => "123146079694899",
         'baseUrl' => "https://qbonline-e2e.api.intuit.com/"
));
$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");

$CompanyInfo = $dataService->getCompanyInfo();
$error = $dataService->getLastError();
if ($error) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
} else {
    $nameOfCompany = $CompanyInfo->CompanyName;
    echo "Test for OAuth Complete. Company Name is {$nameOfCompany}. Returned response body:\n\n";
    $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($CompanyInfo, $somevalue);
    echo $xmlBody . "\n";
}
 ?>
