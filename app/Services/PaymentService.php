<?php

namespace App\Services;

use App\Constants\ResultCode;

class PaymentService
{
    public function __construct() {}

    /**
     * Returns a message based on payment status code
     *
     * @param integer $statusCode
     * @return string
     */
    public function handlePaymentStatusCode(int $statusCode)
    {
        // Can return an array consisting of tailwind style code and icon class or icon link
        switch ($statusCode) {
            case ResultCode::SUCCESS:
                return 'Transaction success';
            case ResultCode::ACCESS_DENIED:
                return 'Access denied';
            case ResultCode::DUPLICATE_ORDER_ID:
                return 'Duplicate orderId';
            case ResultCode::DUPLICATE_REQUEST_ID:
                return 'Duplicate requestId';
            case ResultCode::MAINTENANCE:
                return 'System is maintenance';
            case ResultCode::TRANSACTION_CANCEL:
                return 'Transaction denied';
            case ResultCode::WRONG_FORMAT:
                return 'Wrong format';
            default:
                return 'There is something wrong';
        }
    }
}
