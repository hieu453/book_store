<?php

namespace App\Helpers\Payment;

class Environment
{
    public string $partnerCode;

    public string $accessKey;

    public string $secretKey;


    public function __construct()
    {
        $this->partnerCode = env('M_PARTNER_CODE', 'MOMOBKUN20180529');
        $this->accessKey = env('M_ACCESS_KEY', 'klm05TvNBzhg7h7j');
        $this->secretKey = env('M_SECRET_KEY', 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa');
    }
}
