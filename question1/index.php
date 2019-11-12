<?php
ini_set('display_errors', 1);

function callAPI($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOlsibW9ubmlmeS1wYXltZW50LWVuZ2luZSJdLCJzY29wZSI6WyJwcm9maWxlIl0sImV4cCI6MTU3MzU2NTAwMSwiYXV0aG9yaXRpZXMiOlsiTVBFX1JFVFJJRVZFX1JFU0VSVkVEX0FDQ09VTlQiLCJNUEVfREVMRVRFX1JFU0VSVkVEX0FDQ09VTlQiLCJNUEVfUkVUUklFVkVfUkVTRVJWRURfQUNDT1VOVF9UUkFOU0FDVElPTlMiLCJNUEVfSU5JVElBTElaRV9QQVlNRU5UIiwiTVBFX1JFU0VSVkVfQUNDT1VOVCIsIk1QRV9DQU5fUkVUUklFVkVfVFJBTlNBQ1RJT04iXSwianRpIjoiM2UxYzYzOGYtZGUyNi00MWViLWJlZmMtODdjMDc4M2U4M2IwIiwiY2xpZW50X2lkIjoiTUtfVEVTVF9XRDdUWkNNUVY3In0.XyEAJNRXZ-SomGsmKY62086pAxWJVZlMmz19iB20-Iyxj1ghe_m_v9iW6fwDXsE4mHkfbhxmdLgzeuefiy4yjPKsUsJXgFwl8J5dELeUn9e_dvcrXUxl2pph6Lp-bL_YT7QMMbW1g9oD3JmA8nE6DL63Wb4j-0cRZO9RLJ4niqumyDMgeCL3weGumQjvtAYVWQttl5jdj040NyiF6mG7CiedPfOJgJZTLQ93RBZGJT6zI5ihdCD5ntSGGjtBH_D0zafnVnUa39Ep_TExsQgDYYT8LfT1NvR_KxRCCygym27NcEfkmx1H2Mfyers_NnBaNlqOrgIpIsl6abRKMx77-g',
       'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

// To reserve an account
$data = [
      'accountReference' => '123',
      'accountName' => 'Agbolade Oladayo',
      'currencyCode' => 'NGN',
      'contractCode' => '2957982769',
      'customerEmail' => 'dayoagbolade@gmail.com',
      'incomeSplitConfig' => [
        'subAccountCode' => 'MFY_SUB_319452883228'
      ]
    ];

$make_call = callAPI('POST', 'https://sandbox.monnify.com/api/v1/bank-transfer/reserved-accounts', $data);
$response = json_decode($make_call, true);
var_dump($response);
?>