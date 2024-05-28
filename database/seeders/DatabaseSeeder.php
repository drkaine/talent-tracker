<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Mission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		Candidate::factory(20)->has(Mission::factory())->count(5)->create();
		Candidate::factory(20)->create();
	}
}
