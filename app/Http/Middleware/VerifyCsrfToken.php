<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/paytm-callback',
        '/razorpay-notify',
        '/service/razorpay/notify',
        '/flutter/notify',
        '/service/flutter/notify',
        '/coingate/notify',
        '/user/deposit/paytm-callback',
        '/user/deposit/razorpay-notify',
        '/buyer/deposit/paytm-callback',
        '/buyer/deposit/razorpay-notify',
        '/blockio/notify',
        '/coingate/notify',
        '/user/deposit/flutter/notify*',
        '/buyer/deposit/flutter/notify*',
    ];
}
