<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
	use HasFactory;

	protected $fillable = [
		'start_date',
		'title',
		'candidate_id',
		'end_date',
	];
}
