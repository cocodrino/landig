<?php

$url = "http://netquatro.co/miportal/includes/api.php"; # URL to WHMCS API file
$results = null;

$postfields["username"] = 'superadminnetq25';
$postfields["accesskey"] = 'qu3rtiP4ssC0ntr0lCL4v3';
$postfields["password"] = md5('18yooDp9cUKfYdWVpPa');
$postfields["action"] = "addclient"; #action performed by the [[API:Functions]]

$postfields["firstname"] = "Test";
$postfields["lastname"] = "User";
$postfields["companyname"] = "WHMCS";
$postfields["email"] = "demo@whmcs.com";
$postfields["address1"] = "123 Demo Street";
$postfields["city"] = "Demo";
$postfields["state"] = "Florida";
$postfields["postcode"] = "AB123";
$postfields["country"] = "US";
$postfields["phonenumber"] = "123456789";
$postfields["password2"] = "demo";
$postfields["currency"] = "1";

try{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 100);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    $data = curl_exec($ch);
    curl_close($ch);
    echo ($data);

}catch (Exception $e){
    echo($e);
}



?>