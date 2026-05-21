<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tithes', function (Blueprint $table) {
            // Remove old member_id column
            $table->dropForeign(['member_id']);
            $table->dropColumn('member_id');

            // Remove old amount and type columns
            $table->dropColumn('amount');
            $table->dropColumn('type');

            // Add new columns
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('tithe_amount', 10, 2)->default(0);
            $table->decimal('offering_amount', 10, 2)->default(0);
            $table->decimal('donation_amount', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('tithes', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
            $table->dropColumn('tithe_amount');
            $table->dropColumn('offering_amount');
            $table->dropColumn('donation_amount');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['tithe', 'offering', 'donation'])->default('tithe');
        });
    }
};