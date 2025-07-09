<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::factory()->count(10)->create();

        Report::factory()->create([
            'user_id' => 11, // Assuming user with ID 11 exists
            'type' => 'monthly',
            'start_date' => now()->startOfMonth(),
            'end_date' => now()->endOfMonth(),
            'total_income' => 5000,
            'total_expense' => 3000,
            'balance' => 2000,
        ]);
    }
}
