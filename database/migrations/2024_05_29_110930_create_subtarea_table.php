<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubtareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtarea', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 250);
            $table->string('descripcion', 600)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('situacion',10)->nullable();
            $table->boolean('estado')->default(true);
            $table->integer('prioridad')->nullable();
            $table->double('meta')->nullable();        
            $table->double('avance')->nullable();
            $table->unsignedBigInteger('id_tarea')->nullable();
            $table->foreign('id_tarea')->references('id')->on('tarea');            
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
        Schema::dropIfExists('subtarea');
    }
}
