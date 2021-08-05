<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineRequestStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_request_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('online_request_tracker_id');
            $table->unsignedBigInteger('online_request_procedure_id');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->unsignedBigInteger('next_step')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_completed');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('online_request_tracker_id')->references('id')->on('online_request_trackers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('online_request_procedure_id')->references('id')->on('online_request_procedures')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('next_step')->references('id')->on('online_request_steps')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_request_steps');
    }
}
