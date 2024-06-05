<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarea', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 250);
            $table->string('descripcion', 600)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('prioridad')->nullable();
            $table->double('meta')->nullable();        
            $table->double('avance')->nullable();
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->foreign('id_proyecto')->references('id')->on('proyecto');            
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
        Schema::dropIfExists('tarea');
    }
}
