<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('url_analytics', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('url_id');
        $table->string('user_agent')->nullable();
        $table->string('ip_address')->nullable();
        $table->timestamps();

        $table->foreign('url_id')->references('id')->on('urls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_analytics');
    }
};
