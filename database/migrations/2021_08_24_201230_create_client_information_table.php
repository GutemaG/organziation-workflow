<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('online_request_tracker_id');
            $table->string('name');
            $table->string('value');
            $table->boolean('is_file');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('online_request_tracker_id')->references('id')
                ->on('online_request_trackers')->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_information');
    }
}
