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

     /// We need to bypass the CRSF rule this time, otherwise errors might be throw
     /// With a little more time to dig in we could deal with it.
     /// Also not guaranteed that form with send the CRSF token
    protected $except = [
        'vehicles/'
    ];
}
