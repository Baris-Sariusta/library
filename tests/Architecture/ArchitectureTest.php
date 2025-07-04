<?php

declare(strict_types=1);

arch('all classes should be final')
    ->expect('App')
    ->classes()
    ->toBeFinal()
    ->ignoring('App\Contracts');
