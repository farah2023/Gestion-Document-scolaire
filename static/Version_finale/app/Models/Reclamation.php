<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;

    //declaration du nom de la table
    protected $table = 'reclamations';

    //declaration des colonnes
    protected $fillable = [
        'id_client',
        'id_expert',
        'description',
        'sender',
    ];

    // Indiquer que les colonnes peuvent être nulles
    protected $nullable = [
        
    ];

    protected $dates = ['created_at', 'updated_at'];

}
