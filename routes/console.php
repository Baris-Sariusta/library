<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

Artisan::command('pint', function () : void
{
    passthru('./vendor/bin/pint --ansi');
})->purpose('Run pint');
