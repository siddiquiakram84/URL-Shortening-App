<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('urls', function (Blueprint $table) {
        $table->unsignedInteger('access_count')->default(0);
        $table->timestamp('last_accessed_at')->nullable();
    });
}

public function down()
{
    Schema::table('urls', function (Blueprint $table) {
        $table->dropColumn('access_count');
        $table->dropColumn('last_accessed_at');
        
    });
}

};
