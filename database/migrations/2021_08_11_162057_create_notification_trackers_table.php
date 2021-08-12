<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_trackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('online_request_step_id');
            $table->softDeletes();
            $table->timestamps();

           $table->foreign('online_request_step_id')->references('id')->on('online_request_steps')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_trackers');
    }
}
