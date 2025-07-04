<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Loan;
use Illuminate\Database\Seeder;

final class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Loan::factory()->count(15)->create();
    }
}
