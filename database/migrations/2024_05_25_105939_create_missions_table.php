<?php

declare(strict_types = 1);

use App\Models\Candidate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('missions', function (Blueprint $table): void {
			$table->id();
			$table->string('title');
			$table->foreignIdFor(Candidate::class, 'candidate_id')->nullable();
			$table->date('start_date');
			$table->date('end_date');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('missions');
	}
};
