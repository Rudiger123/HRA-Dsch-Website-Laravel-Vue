
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Exécuter les migrations.
	 * Table des tarifs par service médical
	 */
	public function up(): void
	{
		Schema::create('tarifs', function (Blueprint $table) {
			$table->id();
			$table->foreignId('service_id')->constrained()->onDelete('cascade');
			$table->string('designation', 150); // Ex: "Accouchement normal"
			$table->integer('montant'); // Montant en FCFA
			$table->enum('type_patient', ['normal', 'etudiant', 'urgence'])->default('normal');
			$table->text('details')->nullable(); // Ce qui est inclus/non inclus
			$table->timestamps();

			// Index pour améliorer les performances des requêtes
			$table->index(['service_id', 'type_patient']);
		});
	}

	/**
	 * Annuler les migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('tarifs');
	}
};
