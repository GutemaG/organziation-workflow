<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affair_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->unsignedInteger('step');
            $table->unsignedBigInteger('responsible_bureau_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('affair_id')->references('id')->on('affairs')->onDelete('cascade');
            $table->foreign('responsible_bureau_id')->references('id')->on('bureaus')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedures');
    }
}
