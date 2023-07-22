<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users'); // DISABLED ON PLANETSCALE!
            $table->string('name');
            $table->string('region');
            $table->string('bucket');
            $table->string('key');
            $table->boolean('is_public')->default(true);
            $table->boolean('is_backedup')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
