<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsableTareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsable_tarea', function (Blueprint $table) {
            $table->id();
            $table->string('funcion', 250);
            $table->unsignedBigInteger('id_tarea')->nullable();
            $table->foreign('id_tarea')->references('id')->on('tarea');  
            $table->unsignedBigInteger('id_persona')->nullable();
            $table->foreign('id_persona')->references('id')->on('persona');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsable_tarea');
    }
}
