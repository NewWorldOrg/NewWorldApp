<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medication_histories', function (Blueprint $table) {
            $table->decimal('amount', 11, 3)
                ->unsigned()
                ->comment('服薬量')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medication_histories', function (Blueprint $table) {
            //
        });
    }
};
