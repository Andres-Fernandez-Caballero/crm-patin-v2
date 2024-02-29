<?php

namespace App\Enums;

enum PaymentState: string
{
    case PAID = 'pago';
    case UNPAID = 'pendiente';
}
