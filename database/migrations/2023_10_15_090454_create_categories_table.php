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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('charger')->nullable();;//電源があるか
            $table->integer('morning')->nullable();;
            $table->integer('lunch')->nullable();;
            $table->integer('dinner')->nullable();;
            $table->integer('night')->nullable();;//深夜営業しているか
            $table->integer('pet')->nullable();;//ペット可あるか
            $table->string('place_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
