<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*--------------------------------------------------------------------------
    S3に格納する画像ファイルのパスとログイン中のユーザIDを格納するimagesテーブル
--------------------------------------------------------------------------*/

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('path');
            $table->text('description')->nullable();
            $table->string('style')->nullable();
            $table->string('officialHp')->nullable();
            $table->string('twitter')->nullable();
            $table->string('insta')->nullable();
            $table->timestamps();
            
            // 外部キー制約
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
        Schema::dropIfExists('artists');
    }
}
