<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->integer('packing_id')->unique()->nullable(true)->comment('Идентификатор уровня товарной упаковки. Главный идентификатор номенклатурной позиции');
            $table->integer('desc_id')->nullable(true)->comment('ID описания препарата из блока');
            $table->integer('prep_id')->index()->nullable(true)->comment('Идентификатор уровня препарата');
            $table->string('prep_short', 500)->nullable(true)->comment('Короткое название');
            $table->string('prep_full', 500)->nullable(true)->comment('Полное название');
            $table->string('amount', 255)->nullable(true)->comment('Кол-во в упаковке');
            $table->integer('as_id')->index()->nullable(true)->comment('Id действующего вещества');
            $table->string('as_name_rus', 300)->nullable(true)->index()->comment('Название действующего вещества');
            $table->string('as_name_primary', 300)->nullable(true)->index()->comment('Название действующего вещества');
            $table->string('as_name_secondary', 300)->nullable(true)->index()->comment('Название действующего вещества');
            $table->integer('dosage_form_id')->index()->nullable(true)->comment('Id формы выпуска');
            $table->string('dosage_form_full_name', 300)->nullable(true);
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
        Schema::dropIfExists('drugs');
    }
}
