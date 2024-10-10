<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToClientTable extends Migration
{
    public function up()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);  // Assuming new accounts are active by default
        });
    }

    public function down()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
