<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;

/** @untested */
final class ApiController extends Controller
{
    use ApiResponses;

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
