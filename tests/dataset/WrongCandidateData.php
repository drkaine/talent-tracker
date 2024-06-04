<?php

declare(strict_types = 1);

return [
	[
		[
			'first_name' => fake()->firstName(),
			'name' => 1,
		],
	],
	[
		[
			'first_name' => fake()->firstName(),
		],
	],
	[
		[
			'first_name' => fake()->firstName(),
		],
	],
	[
		[
			'name' => fake()->name(),
		],
	],
	[
		[
			'first_name' => 1,
			'name' => fake()->name(),
		],
	],
	[
		[
			'first_name' => '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789',
			'name' => fake()->name(),
		],
	],
	[
		[
			'first_name' => fake()->firstName(),
			'name' => '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789',
		],
	],
];