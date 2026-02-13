
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Exécuter les migrations.
	 * Table pivot pour relation many-to-many entre médecins et services
	 */
	public function up(): void
	{
		Schema::create('medecin_service', function (Blueprint $table) {
			$table->id();
			$table->foreignId('medecin_id')->constrained()->onDelete('cascade');
			$table->foreignId('service_id')->constrained()->onDelete('cascade');
			$table->timestamps();

			// Un médecin ne peut être assigné qu'une fois au même service
			$table->unique(['medecin_id', 'service_id']);
		});
	}

	/**
	 * Annuler les migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('medecin_service');
	}
};
