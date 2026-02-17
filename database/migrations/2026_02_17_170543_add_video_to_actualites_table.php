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
        Schema::table('actualites', function (Blueprint $table) {
            // Ajouter champ vidéo
            $table->string('video')->nullable()->after('image'); // URL ou chemin vidéo
            $table->string('video_type')->nullable()->after('video'); // 'upload', 'youtube', 'vimeo'

            // Ajouter compteur de likes
            $table->integer('likes_count')->default(0)->after('vues');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actualites', function (Blueprint $table) {
            $table->dropColumn(['video', 'video_type', 'likes_count']);
        });
    }
};
