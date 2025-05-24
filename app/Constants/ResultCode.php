<?php

namespace App\Constants;

class ResultCode
{
    public const SUCCESS = 0;

    public const MAINTENANCE = 10;

    public const ACCESS_DENIED = 11;

    public const WRONG_FORMAT = 20;

    public const DUPLICATE_REQUEST_ID = 40;

    public const DUPLICATE_ORDER_ID = 41;

    public const TRANSACTION_CANCEL = 1002;

    public const TRANSACTION_DENIED = 1006;
}
