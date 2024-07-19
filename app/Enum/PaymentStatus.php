<?php

namespace App\Enum;

enum PaymentStatus: int
{
    case PENDING_PAYMENT = 0;
    case DOWN_PAYMENT = 1;
    case PAID = 2;
}
