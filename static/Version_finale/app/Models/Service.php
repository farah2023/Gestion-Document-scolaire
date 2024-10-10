<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_expert', 'nom_service', 'crenau_dispo', 'prix', 'statut'
    ];

    public function partenaire() {
        return $this->belongsTo(Partenaire::class, 'id_expert');
    }


}
