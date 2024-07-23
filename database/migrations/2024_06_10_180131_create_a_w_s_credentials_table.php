<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('a_w_s_credentials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('access_key_id');
            $table->string('access_key_secret');
            $table->foreignUuid('user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_w_s_credentials');
    }
};
