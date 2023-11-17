<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyticsTable extends Migration
{
    public function up()
    {
    Schema::create('analytics', function (Blueprint $table) {
        $table->id();
        $table->foreignId('url_id')->constrained()->cascadeOnDelete();
        $table->string('user_agent');
        $table->ipAddress('ip_address');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('analytics');
    }

};
