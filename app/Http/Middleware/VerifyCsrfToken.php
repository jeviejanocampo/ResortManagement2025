<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/customers/insert',
        'api/login/customers',
        'api/fetch-option-categories',
        'api/fetch-rooms',
        'api/fetch-room-gallery',
    ];
}
