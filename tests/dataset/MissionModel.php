<?php

declare(strict_types = 1);

return [
	[
		[
			'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
			'end_date' => fake()->dateTimeBetween('now', '+1 year'),
			'title' => fake()->word(),
			'candidate_id' => 1,
		],
	],
	[
		[
			'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
			'end_date' => fake()->dateTimeBetween('now', '+1 year'),
			'title' => fake()->word(),
			'candidate_id' => null,
		],
	],
];
