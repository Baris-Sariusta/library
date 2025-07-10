<?php

declare(strict_types=1);

namespace App\Models;

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
     * Generate the api token so the user can be logged in.
     */
    public function generateApiToken() : string
    {
        return $this->createToken(
            name: "API token for {$this->email}",
            expiresAt: now()->addMonth(), // The token should expire a month after it's given...
        )->plainTextToken; // The plain text of the token...
    }
}
