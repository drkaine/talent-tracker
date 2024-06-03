<?php

declare(strict_types = 1);

use Carbon\Carbon;

return [
	[
		'mission' => [
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
			'title' => fake()->word(),
			'candidate_id' => 1,
		],
	],
	[
		'mission' => [
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'title' => fake()->word(),
			'candidate_id' => 1,
		],
	],
	[
		'mission' => [
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
			'candidate_id' => 1,
		],
	],
	[
		'mission' => [
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
			'title' => fake()->word(),
		],
	],
	[
		'mission' => [
			'start_date' => 1,
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
			'title' => fake()->word(),
			'candidate_id' => 1,
		],
	],
	[
		'mission' => [
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'end_date' => 1,
			'title' => fake()->word(),
			'candidate_id' => 1,
		],
	],
	[
		'mission' => [
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
			'title' => 1,
			'candidate_id' => 1,
		],
	],
	[
		'mission' => [
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
			'title' => fake()->word(),
			'candidate_id' => 'F',
		],
	],
	[
		'mission' => [
			'start_date' => Carbon::parse(fake()->dateTimeBetween('now', '+2 year'))->format('Y/m/d'),
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
			'title' => fake()->word(),
			'candidate_id' => 1,
		],
	],
	[
		'mission' => [
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'end_date' => Carbon::parse(fake()->dateTimeBetween('-2 year', 'now'))->format('Y/m/d'),
			'title' => fake()->word(),
			'candidate_id' => 1,
		],
	],
	[
		[
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
			'title' => fake()->word(),
			'candidate_id' => null,
		],
	],
	[
		'mission' => [
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
			'title' => fake()->word(),
			'candidate_id' => 1,
		],
	],
];
