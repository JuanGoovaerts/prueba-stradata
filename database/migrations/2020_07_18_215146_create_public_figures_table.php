<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePublicFiguresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_figures', function (Blueprint $table) {
            $table->id();
            $table->string('departamento')->nullable();
            $table->string('localidad')->nullable();
            $table->string('municipio')->nullable();
            $table->string('nombre')->nullable();
            $table->string('años_activo')->nullable();
            $table->string('tipo_persona')->nullable();
            $table->string('tipo_cargo')->nullable();
            $table->timestamps();
        });

        DB::statement('
            create fulltext index public_figures_ft_index
            on public_figures(nombre)
            with parser ngram
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public_figures');
    }
}
