<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActualiteLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'actualite_id',
        'user_identifier',
        'reaction_type',
    ];

    /**
     * Relation avec l'actualité
     */
    public function actualite()
    {
        return $this->belongsTo(Actualite::class);
    }
}
