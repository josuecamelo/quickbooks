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