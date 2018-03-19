<?php

$client_id = "roberto.briones@salazarisrael.cl";
$client_secret = "Pa$$.2018";
$code = "a6d0fdbef96c97653e48974d9f2e17abdac81fc8";


$service_url = 'https://qis.quiter.com/qis/oauth/token';
$data = array(
    "grant_type" => 'authorization_code',
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "code" => $code
);

$curl = curl_init($service_url);
//curl_setopt($curl, CURLOPT_VERBOSE, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','Content-Type: application/x-www-form-urlencoded'));
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);

echo "respuesta curl: $curl_response";
echo "";

curl_close($curl);

//return $jsonres;

?>


