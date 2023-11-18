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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            //user_id
            //store_id
            $table->string('title',100);
            $table->string('body',4000);
            $table->string('rating',5)->nullable();//５段階評価
            $table->string('image_url')->nullable();//写真機能入れる
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            //GooglePlaceIdを入れる
            $table->string('place_id');
            $table->string('shopName');
            $table->integer('charger')->nullable();//電源があるか
            $table->integer('morning')->nullable();
            $table->integer('lunch')->nullable();
            $table->integer('dinner')->nullable();
            $table->integer('night')->nullable();//深夜営業しているか
            $table->integer('pet')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
