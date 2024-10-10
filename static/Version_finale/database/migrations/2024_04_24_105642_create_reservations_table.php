<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_service');
            $table->string('duree');
            $table->string('statut');
            $table->date('date_reservation');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->timestamps();

            $table->foreign('id_client')->references('id')->on('client')
                ->onDelete('cascade');
            $table->foreign('id_service')->references('id')->on('services')
                ->onDelete('cascade');
        });
    }

};
