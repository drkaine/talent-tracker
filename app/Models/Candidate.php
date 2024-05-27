<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
	use HasFactory;

	public function assignments(): HasMany
	{
		return $this->hasMany(Assignment::class);
	}
}
