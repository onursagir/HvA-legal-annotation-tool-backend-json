<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * @codeCoverageIgnore
 */
class EncryptCookies extends Middleware
{
    /** @inheritdoc */
    protected $except = [
        //
    ];
}
