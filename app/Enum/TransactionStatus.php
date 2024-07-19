<?php

namespace App\Enum;

enum TransactionStatus: int
{
    case WAITING = 0;
    case TODO = 1;
    case ONPROGRESS = 2;
    case DONE = 3;
    case READY_TO_BE_PICKED_UP = 4;
    case READY_TO_BE_DELIVERED = 5;
    case OUT_FOR_DELIVERY = 6;
    case COMPLETED = 7;
}
