<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model as BaseModel;

/** @untested */
abstract class Model extends BaseModel
{
    /**
     * Get the database table for this Eloquent Model.
     */
    public static function getTableName(?string $as = null) : string
    {
        $table = (new static)->getTable();

        if ($as)
        {
            $table .= " as {$as}";
        }

        return $table;
    }

    /**
     * Get the given column from the database table for this
     * Eloquent Model, optionally with an alias.
     */
    public static function getColumnName(string $column, ?string $as = null) : string
    {
        $column = static::getTableName() . '.' . $column;

        if ($as)
        {
            $column .= " as {$as}";
        }

        return $column;
    }
}
