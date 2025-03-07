<?php

namespace App\Helpers\Payment;

use App\Helpers\Curl;

class Momo
{
    public function __construct() {}

    /**
     * Process Momo ATM payment
     *
     * @param Environment $env
     * @param string $endpoint
     * @param string $amount
     * @param string $name
     * @param string $orderInfo
     * @param string $redirectUrl
     * @return array
     */
    public static function process(
        Environment $env,
        string $endpoint,
        string $amount,
        string $orderId,
        string $orderInfo,
        string $redirectUrl,
    )
    {
        $partnerCode = $env->partnerCode;
        $accessKey = $env->accessKey;
        $secretKey = $env->secretKey;
        $ipnUrl = "https://webhook.site/09d42fa4-621d-499f-b5f0-687af64406da";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
        $result = Curl::execPostRequest($endpoint, json_encode($data));

        return json_decode($result, true);  // decode json
    }
}
