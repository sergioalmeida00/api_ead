<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplySupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_support', function (Blueprint $table) {
            $table->uuid('id');
            $table->text('description');
            $table->uuid('support_id')->nullable(false);
            $table->uuid('user_id')->nullable(false);
            $table->timestamps();

            $table->foreign('support_id')->references('id')->on('supports')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reply_support');
    }
}
