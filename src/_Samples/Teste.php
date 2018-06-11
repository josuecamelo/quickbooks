<?php
session_start();
$_SESSION['state'] = $_GET['state'];
$_SESSION['code'] = $_GET['code'];
$_SESSION['realmId']   = $_GET['realmId'];


//header("Location: OAuth2TokenGeneration_Two.php");
//header("Location: CustomerCreate.php");
header("Location: ItemCreation.php");