<?php

/**
 * @param $url
 * @param string $method
 * @param int $timeout
 * @param array $postDataArray
 * @param string $contentType
 * @param array $headers
 * @param int[] $validResponseCodes
 * @return bool|string
 * @throws \Exception
 */
function curlRequest(
    $url,
    $method = 'GET',
    $timeout = 10,
    $postDataArray = [],
    $contentType = 'application/json',
    $headers = [],
    $validResponseCodes = [200, 201, 204]
)
{
    if ($method == 'POST') {
        array_push($headers, "Content-Type: " . $contentType);
    }
    $curlOptions = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false
    ];
    if ($method == 'POST') {
        if ($contentType == 'application/json') {
            $curlOptions[CURLOPT_POSTFIELDS] = json_encode($postDataArray);
        } else {
            $curlOptions[CURLOPT_POSTFIELDS] = $postDataArray;
        }
    }
    $curl = curl_init();
    curl_setopt_array($curl, $curlOptions);

    $response = curl_exec($curl);

    $error = curl_error($curl);
    $curlInfo = curl_getinfo($curl);
    if (in_array($curlInfo['http_code'], $validResponseCodes) == false) {
        throw new \Exception(json_encode($response), $curlInfo['http_code']);
    }
    curl_close($curl);
    if ($error) {
        throw new \Exception($error);
    }
    return $response;
}

function prepareStatementQuestionMarks($count)
{
    $questionMarkString = "";
    for ($i = 1; $i <= $count; $i++) {
        if ($i == $count) {
            $questionMarkString .= '?';
            continue;
        }
        $questionMarkString .= '?, ';
    }
    return $questionMarkString;
}