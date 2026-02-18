<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->string('gender')->nullable()->after('date_of_birth');
            $table->text('bio')->nullable()->after('gender');
            $table->string('emergency_contact')->nullable()->after('bio');
            $table->string('address')->nullable()->after('emergency_contact');
            $table->string('avatar')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'date_of_birth',
                'gender',
                'bio',
                'emergency_contact',
                'address',
                'avatar',
            ]);
        });
    }
};
