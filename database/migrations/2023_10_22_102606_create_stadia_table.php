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
        Schema::create('stadia', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location_link')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->foreignIdFor(\App\Models\StadiumType::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\StadiumOwner::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stadia');
    }
};
