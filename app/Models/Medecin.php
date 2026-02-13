<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Medecin extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle
     */
    protected $table = 'medecins';

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'nom',
        'slug',
        'specialite',
        'diplomes',
        'photo',
        'bio',
        'langues',
        'actif',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'actif' => 'boolean',
    ];

    /**
     * Relation many-to-many : Un médecin travaille dans plusieurs services
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'medecin_service');
    }

    /**
     * Scope : Récupérer uniquement les médecins actifs
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope : Filtrer par spécialité
     */
    public function scopeParSpecialite($query, $specialite)
    {
        return $query->where('specialite', $specialite);
    }
}
