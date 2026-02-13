
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Exécuter les migrations.
	 * Table des demandes de rendez-vous des patients
	 */
	public function up(): void
	{
		Schema::create('rdv_requests', function (Blueprint $table) {
			$table->id();
			$table->string('nom_patient', 150);
			$table->integer('age')->nullable();
			$table->string('telephone', 20); // Format +237XXXXXXXXX
			$table->foreignId('service_id')->constrained();
			$table->text('motif')->nullable(); // Raison de la consultation
			$table->enum('statut', ['en_attente', 'confirme', 'annule'])->default('en_attente');
			$table->boolean('confirmation_whatsapp')->default(false);
			$table->timestamp('date_souhaitee')->nullable();
			$table->timestamps();

			// Index pour améliorer les performances
			$table->index('statut');
			$table->index('created_at');
		});
	}

	/**
	 * Annuler les migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('rdv_requests');
	}
};
