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

    protected ApiController $policyClass;

    public function include(string $relationship) : bool
    {
        $param = request()->get('include');

        if (! isset($param))
        {
            return false;
        }

        $includeValues = explode(',', mb_strtolower($param));

        return in_array(mb_strtolower($relationship), $includeValues);
    }

    public function isAble($ability, $targetModel)
    {
        return $this->authorize($ability, [$targetModel, $this->policyClass]);
    }
}
