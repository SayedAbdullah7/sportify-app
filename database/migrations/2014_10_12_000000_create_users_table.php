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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('username')->unique()->nullable();
            $table->boolean('gender');
            $table->date('day_of_birth');
            $table->string('email')->unique()->nullable();
            $table->tinyInteger('height')->unsigned()->nullable();// max value 255
            $table->string('address')->nullable();
            $table->text('about_me')->nullable();

            $table->timestamp('email_verified_at')->nullable();
//            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
