<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyticsTable extends Migration
{
    public function up()
    {
        Schema::create('url_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('url_id');
            $table->text('user_agent')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->date('access_date');
            $table->integer('access_count')->default(0);
            $table->timestamps();

            // Add foreign key constraint if needed
            $table->foreign('url_id')->references('id')->on('urls')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('url_analytics');
    }
};
