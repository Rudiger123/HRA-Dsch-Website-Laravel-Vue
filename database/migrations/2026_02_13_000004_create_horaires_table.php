
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Exécuter les migrations.
	 * Table des horaires d'ouverture par service
	 */
	public function up(): void
	{
		Schema::create('horaires', function (Blueprint $table) {
			$table->id();
			$table->foreignId('service_id')->constrained()->onDelete('cascade');
			$table->enum('jour_semaine', [
				'Lundi',
				'Mardi',
				'Mercredi',
				'Jeudi',
				'Vendredi',
				'Samedi',
				'Dimanche'
			]);
			$table->time('ouverture'); // Ex: 08:00:00
			$table->time('fermeture'); // Ex: 17:00:00
			$table->string('note', 200)->nullable(); // Ex: "Urgences uniquement"
			$table->timestamps();

			// Un service a UN horaire par jour de la semaine
			$table->unique(['service_id', 'jour_semaine']);
		});
	}

	/**
	 * Annuler les migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('horaires');
	}
};
