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
        Schema::table('users', function (Blueprint $table) {
            $table->string('instructor_status')->nullable()->after('role'); // e.g., pending, approved, rejected
            $table->text('experience')->nullable()->after('instructor_status');
            $table->string('stripe_account_id')->nullable()->after('experience');
            $table->string('presentation_video_url')->nullable()->after('stripe_account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'instructor_status',
                'experience',
                'stripe_account_id',
                'presentation_video_url',
            ]);
        });
    }
};
