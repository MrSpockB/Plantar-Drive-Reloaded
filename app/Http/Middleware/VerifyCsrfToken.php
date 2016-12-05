<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'data/clientes',
        'data/clientes/*',
        'data/odts',
        'data/odts/*',
        'registerUser',
        'registerAdmin',
        'login',
        'cliente/*',
    ];
}
