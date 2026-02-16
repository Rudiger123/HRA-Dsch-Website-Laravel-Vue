<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('actualites', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('extrait'); // Résumé court (200 caractères)
            $table->longText('contenu'); // Contenu complet HTML
            $table->string('image')->nullable(); // Chemin image de couverture
            $table->string('categorie'); // nutrition, prévention, événements, etc.
            $table->string('auteur')->default('Équipe HRA'); // Nom de l'auteur
            $table->boolean('publie')->default(true);
            $table->timestamp('date_publication')->useCurrent();
            $table->integer('vues')->default(0); // Compteur de vues
            $table->timestamps();

            $table->index('slug');
            $table->index('categorie');
            $table->index('publie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actualites');
    }
};
