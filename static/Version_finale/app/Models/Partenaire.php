<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model
{
    use HasFactory;

    protected $table = 'partenaire';
    protected $fillable = [
        'nom_par', 'prenom_par', 'password', 'ville', 'email', 'photo_par',
        'nbr_experience', 'domaine_expertise', 'connexion','is_active',
    ];

    public function services() {
        return $this->hasMany(Service::class, 'id_expert');
    }
}
