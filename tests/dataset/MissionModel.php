<?php

declare(strict_types = 1);

use Carbon\Carbon;

return [
	[
		[
			'start_date' => Carbon::parse(fake()->dateTimeBetween('-1 year', 'now'))->format('Y/m/d'),
			'end_date' => Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->format('Y/m/d'),
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
];
