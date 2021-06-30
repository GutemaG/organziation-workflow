<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBureauTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bureaus', function (Blueprint $table) {
            $table->unsignedBigInteger('accountable_to')->nullable();

            $table->foreign('accountable_to')->references('id')->on('bureaus') ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bureaus', function (Blueprint $table) {
            //
        });
    }
}
