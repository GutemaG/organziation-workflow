<?php

use App\Utilities\InputFieldType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineRequestPrerequisiteInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_request_prerequisite_inputs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('online_request_id');
            $table->string('name');
            $table->string('input_id');
            $table->enum('type', InputFieldType::all());
            $table->boolean('required')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('online_request_id')->references('id')
                ->on('online_requests')->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_fields');
    }
}
