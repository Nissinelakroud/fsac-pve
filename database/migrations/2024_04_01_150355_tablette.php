<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tablettes', function (Blueprint $table) {
            $table->bigIncrements('id_tablette');
            $table->char('adresse_mac', 12);
            $table->integer('numero_serie');
            $table->boolean('statut');
            $table->integer('code_association');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tablettes');
    }
};
