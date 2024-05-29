<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
	use HasFactory;

	protected $fillable = [
		'first_name',
		'name',
	];

	public function missions(): HasMany
	{
		return $this->hasMany(Mission::class);
	}
}
