<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'nom',
        'slug',
        'description',
        'icon',
        'tarif_consultation',
        'actif',
        'ordre',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'actif' => 'boolean',
        'tarif_consultation' => 'integer',
        'ordre' => 'integer',
    ];

    /**
     * Relation : Un service a plusieurs horaires
     */
    public function horaires(): HasMany
    {
        return $this->hasMany(Horaire::class);
    }

    /**
     * Relation : Un service a plusieurs tarifs
     */
    public function tarifs(): HasMany
    {
        return $this->hasMany(Tarif::class);
    }

    /**
     * Relation : Un service a plusieurs demandes de rendez-vous
     */
    public function rdvRequests(): HasMany
    {
        return $this->hasMany(RdvRequest::class);
    }

    /**
     * Relation many-to-many : Un service a plusieurs médecins
     */
    public function medecins(): BelongsToMany
    {
        return $this->belongsToMany(Medecin::class, 'medecin_service');
    }

    /**
     * Scope : Récupérer uniquement les services actifs
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope : Trier par ordre d'affichage
     */
    public function scopeOrdonne($query)
    {
        return $query->orderBy('ordre');
    }
}
