<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Actualite extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'slug',
        'extrait',
        'contenu',
        'image',
        'categorie',
        'auteur',
        'publie',
        'date_publication',
        'vues'
    ];

    protected $casts = [
        'date_publication' => 'datetime',
        'publie' => 'boolean',
        'vues' => 'integer'
    ];

    // Générer automatiquement le slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($actualite) {
            if (empty($actualite->slug)) {
                $actualite->slug = Str::slug($actualite->titre);
            }
        });
    }

    // Scope : Seulement les articles publiés
    public function scopePublie($query)
    {
        return $query->where('publie', true)
                     ->orderBy('date_publication', 'desc');
    }

    // Scope : Par catégorie
    public function scopeCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    // Incrémenter les vues
    public function incrementVues()
    {
        $this->increment('vues');
    }

    // Formater la date en français
    public function getDateFormatteeAttribute()
    {
        return $this->date_publication->locale('fr')->isoFormat('D MMMM YYYY');
    }

    // Temps de lecture estimé (250 mots/minute)
    public function getTempsLectureAttribute()
    {
        $mots = str_word_count(strip_tags($this->contenu));
        $minutes = ceil($mots / 250);
        return $minutes . ' min de lecture';
    }
}

