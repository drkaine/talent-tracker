<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Candidate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		Candidate::factory(20)->create();
		Assignment::factory(50)->create();
	}
}
