<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laravisor_errors', function (Blueprint $table) {
            $table->id();
            $table->uuid('error_id')->unique();
            $table->string('exception');
            $table->text('message');
            $table->json('stack_trace');
            $table->json('request')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laravisor_errors');
    }
};
