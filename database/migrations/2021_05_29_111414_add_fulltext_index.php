<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddFulltextIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drugs', function (Blueprint $table) {
            DB::statement('ALTER TABLE drugs ADD FULLTEXT search1 (prep_full)');
            DB::statement('ALTER TABLE drugs ADD FULLTEXT search2 (as_name_rus)');
            DB::statement('ALTER TABLE drugs ADD FULLTEXT search3 (as_name_primary)');
            DB::statement('ALTER TABLE drugs ADD FULLTEXT search4 (as_name_secondary)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drugs', function (Blueprint $table) {
            DB::statement('ALTER TABLE drugs DROP index search1');
            DB::statement('ALTER TABLE drugs DROP index search2');
            DB::statement('ALTER TABLE drugs DROP index search3');
            DB::statement('ALTER TABLE drugs DROP index search4');
        });
    }
}
