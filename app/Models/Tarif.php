<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarif extends Model
{
    /** @use HasFactory<\Database\Factories\TarifFactory> */
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'service_id',
        'designation',
        'montant',
        'type_patient',
        'details',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'montant' => 'integer',
    ];

    /**
     * Relation : Un tarif appartient à un service
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
