<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineRequestTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_request_trackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('online_request_id');
            $table->string('token',6)->unique();
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('online_request_id')->references('id')->on('online_requests')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_request_trackers');
    }
}
