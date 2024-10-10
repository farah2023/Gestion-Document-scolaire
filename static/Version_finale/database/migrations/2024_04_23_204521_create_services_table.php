<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_expert'); // Vous devez ajouter cette ligne
            $table->string('nom_service');
            $table->string('crenau_dispo');
            $table->integer('prix');
            $table->integer('statut'); // Par défaut "dispo"
            $table->timestamps();

            // Set up the foreign key constraint
            $table->foreign('id_expert')->references('id')->on('partenaire')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}
