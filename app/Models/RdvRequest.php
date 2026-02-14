<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RdvRequest extends Model
{
    /** @use HasFactory<\Database\Factories\RdvRequestFactory> */
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'nom_patient',
        'age',
        'telephone',
        'service_id',
        'motif',
        'confirmation_whatsapp',
        'date_souhaitee',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'confirmation_whatsapp' => 'boolean',
        'date_souhaitee' => 'datetime',
    ];

    /**
     * Relation : Une demande RDV appartient à un service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
