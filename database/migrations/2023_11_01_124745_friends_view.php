<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
use Staudenmeir\LaravelMergedRelations\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::createMergeView(
            'friends_view',
            [(new \App\Models\User())->acceptedFriendsTo(), (new \App\Models\User())->acceptedFriendsFrom()]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
