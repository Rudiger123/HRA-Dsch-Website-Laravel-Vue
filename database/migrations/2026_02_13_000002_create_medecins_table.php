
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Exécuter les migrations.
	 * Table des médecins de l'hôpital
	 */
	public function up(): void
	{
		Schema::create('medecins', function (Blueprint $table) {
			$table->id();
			$table->string('nom', 150); // Ex: "Dr. Jean-Paul FOKA"
			$table->string('slug', 150)->unique(); // Ex: "dr-jean-paul-foka"
			$table->string('specialite', 100); // Ex: "Cardiologue"
			$table->text('diplomes')->nullable(); // CV formaté avec diplômes
			$table->string('photo')->nullable(); // Chemin vers la photo
			$table->text('bio')->nullable(); // Biographie courte du médecin
			$table->string('langues', 100)->default('Français'); // FR, EN, etc.
			$table->boolean('actif')->default(true);
			$table->timestamps();

			// Index pour améliorer les performances
			$table->index('slug');
			$table->index('specialite');
		});
	}

	/**
	 * Annuler les migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('medecins');
	}
};
