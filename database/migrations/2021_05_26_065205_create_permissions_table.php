<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('delete_FAQ')->default(False);
            $table->boolean('update_FAQ')->default(False);
            $table->boolean('reply_request')->default(False);
            $table->boolean('add_request_to_FAQ')->default(False);
            $table->boolean('delete_request')->default(False);
            $table->boolean('create_bureau')->default(False);
            $table->boolean('update_bureau')->default(False);
            $table->boolean('delete_bureau')->default(False);
            $table->boolean('create_affair')->default(False);
            $table->boolean('update_affair')->default(False);
            $table->boolean('delete_affair')->default(False);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
