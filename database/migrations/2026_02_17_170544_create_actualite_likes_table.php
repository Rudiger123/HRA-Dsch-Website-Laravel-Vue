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
        Schema::create('actualite_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actualite_id')->constrained('actualites')->onDelete('cascade');
            $table->string('user_identifier'); // Email ou identifiant utilisateur pour anonyme
            $table->enum('reaction_type', ['like', 'love', 'wow', 'sad', 'angry'])->default('like'); // Types de réactions
            $table->timestamps();

            // Composite unique key (1 like par utilisateur/actualité)
            $table->unique(['actualite_id', 'user_identifier']);

            // Index pour recherche rapide
            $table->index('actualite_id');
            $table->index('user_identifier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actualite_likes');
    }
};
