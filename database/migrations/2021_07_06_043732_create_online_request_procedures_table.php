<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineRequestProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_request_procedures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('online_request_id');
            $table->unsignedBigInteger('responsible_bureau_id');
            $table->longText('description')->nullable();
            $table->integer('step_number');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('online_request_id')->references('id')->on('online_requests')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

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
        Schema::dropIfExists('online_request_procedures');
    }
}
