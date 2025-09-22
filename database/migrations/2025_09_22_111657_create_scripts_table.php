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
        Schema::create('scripts', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->integer('cart_addon')->nullable();
            $table->string('name');
            $table->string('host')->nullable();
            $table->integer('tracking_time')->nullable();
            $table->integer('convert_click')->nullable();
            $table->json('device_type')->nullable();
            $table->json('social_media')->nullable();
            $table->text('tracking_one_url')->nullable();
            $table->string('main_domain')->nullable();
            $table->boolean('off_location')->default(0);
            $table->json('country')->nullable();

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
        Schema::dropIfExists('scripts');
    }
};
