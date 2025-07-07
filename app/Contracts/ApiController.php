<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/** @untested */
abstract class ApiController
{
    use ApiResponses;
    use AuthorizesRequests;
    use ValidatesRequests;
}
