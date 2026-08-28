<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('zoho_oauth', function (Blueprint $table) {
            $table->id();
            $table->string('refresh_token')->index();
            $table->string('access_token')->unique();
            $table->timestamp('expires_at');
            $table->string('token_type')->nullable();
            $table->string('api_domain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('zoho_oauth');
    }
};
