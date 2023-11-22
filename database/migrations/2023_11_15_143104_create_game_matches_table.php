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
        Schema::create('game_matches', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->boolean('is_completed');
            $table->enum('statues',[]);

            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Stadium::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_matches');
    }
};
