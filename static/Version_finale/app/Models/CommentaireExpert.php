<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentaireExpert extends Model
{
    use HasFactory;

    protected $table = 'commentaire_expert';
    protected $fillable = [
        'id_reservation', 'contenu', 'note', 'date_commentaire'
    ];

    public function reservation() {
        return $this->belongsTo(Reservation::class, 'id_reservation');
    }
}
