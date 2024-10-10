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
        Schema::table('partenaire', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);  // Assuming new accounts are active by default
        });
    }

    public function down()
    {
        Schema::table('partenaire', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
