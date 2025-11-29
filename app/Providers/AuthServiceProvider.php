<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Book;
use App\Models\Loan;
use App\Policies\BookPolicy;
use App\Policies\LoanPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/** @untested-ignore */
final class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Book::class => BookPolicy::class,
        Loan::class => LoanPolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot() : void
    {
        $this->registerPolicies();
    }
}
