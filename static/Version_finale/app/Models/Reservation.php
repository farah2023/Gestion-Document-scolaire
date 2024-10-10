<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_client', 'id_service', 'duree', 'statut', 'date_reservation','date_debut','date_fin'
    ];

    // Relation avec le modèle Client
    public function client() {
        return $this->belongsTo(Client::class, 'id_client');
    }

    // Relation avec le modèle Service
    public function service() {
        return $this->belongsTo(Service::class, 'id_service');
    }

   // Relation avec le modèle CommentaireClient
   public function commentaireClient() {
    return $this->hasOne(CommentaireClient::class, 'id_reservation');
}
public function commentaireExpert() {
    return $this->hasOne(CommentaireExpert::class, 'id_reservation');
}




}
