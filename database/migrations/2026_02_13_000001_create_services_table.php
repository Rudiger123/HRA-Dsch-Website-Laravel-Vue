
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Exécuter les migrations.
	 * Table des services médicaux de l'hôpital
	 */
	public function up(): void
	{
		Schema::create('services', function (Blueprint $table) {
			$table->id();
			$table->string('nom', 100); // Ex: "Pédiatrie"
			$table->string('slug', 100)->unique(); // Ex: "pediatrie"
			$table->text('description'); // Description complète du service
			$table->string('icon', 50)->nullable(); // Nom icon Lucide (ex: "Baby")
			$table->integer('tarif_consultation')->default(5000); // FCFA
			$table->boolean('actif')->default(true);
			$table->integer('ordre')->default(0); // Pour tri affichage
			$table->timestamps();

			// Index pour améliorer les performances
			$table->index('slug');
			$table->index('actif');
		});
	}

	/**
	 * Annuler les migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('services');
	}
};
