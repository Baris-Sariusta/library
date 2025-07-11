<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Models\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/** @tested */
final class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts() : array
    {
        return [
            'role' => UserRole::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the ratings for the user.
     */
    public function ratings() : HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the loans for the user.
     */
    public function loans() : HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Determine if the user is an admin.
     */
    public function isAdmin() : bool
    {
        return $this->admin;
    }
}
