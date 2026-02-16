<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horaire extends Model
{
    /** @use HasFactory<\Database\Factories\HoraireFactory> */
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'service_id',
        'jour_semaine',
        'ouverture',
        'fermeture',
        'note',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'ouverture' => 'datetime:H:i',
        'fermeture' => 'datetime:H:i',
    ];

    /**
     * Relation : Un horaire appartient à un service
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
