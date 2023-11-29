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
        Schema::create('match_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('present')->unsigned();
            $table->integer('required')->unsigned();
            $table->enum('audience',['public','friends','onlyme']);
            $table->text('note')->nullable();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_groups');
    }
};
