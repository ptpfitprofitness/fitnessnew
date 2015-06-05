<?php
// =====================
// account information
// =====================
echo $username = "yogendra";
$pin = "p@ssw0rd1111";
 
 
$proxy = "http://staging-api.call-em-all.com/webservices/ceaapi_v2.asmx?WSDL";
$client = new SoapClient($proxy, array("trace" => true));
$request = array (
"username" => $username,
"pin" => $pin,
);
$response = $client->CheckAccount(array("myRequest" => $request));
 
// =====================

 var_dump($response);
 
// =====================
 
 
print "errorCode :" . $response->CheckAccountResult->errorCode . "\n";
print "errorMessage :" . $response->CheckAccountResult->errorMessage . "\n";
 
if ( $response->CheckAccountResult->errorCode === 0)
{
print "accountStatus :" . $response->CheckAccountResult->accountStatus . "\n";
print "StatusDescription :" . $response->CheckAccountResult->accountStatusDescription . "\n";
print "CallBalance :" . $response->CheckAccountResult->CallBalance . "\n";
print "PendingCallBalance :" . $response->CheckAccountResult->PendingCallBalance . "\n";
print "AvailableCallUnits :" . $response->CheckAccountResult->AvailableCallUnits . "\n";
}
 
function IsNullOrEmptyString($question) {
return (!isset($question) || trim($question)==='');
}

?>