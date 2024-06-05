<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsableProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsable_proyecto', function (Blueprint $table) {
            $table->id();
            $table->string('funcion', 250);
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->foreign('id_proyecto')->references('id')->on('proyecto');  
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
        Schema::dropIfExists('responsable_proyecto');
    }
}
