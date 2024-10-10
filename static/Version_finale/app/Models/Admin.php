<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    //declaration du nom de la table
    protected $table = 'admin';

    //declaration des colonnes
    protected $fillable = [
        'nom',
        'prenom',
        'password',
        'email',
    ];

    // Indiquer que les colonnes peuvent être nulles
    protected $nullable = [
    ];

    protected $dates = ['created_at', 'updated_at'];
}