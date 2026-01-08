<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            // Link to a registered user (optional)
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();

            // Admin reply
            $table->text('admin_reply')->nullable()->after('message');
            $table->timestamp('replied_at')->nullable()->after('admin_reply');

            // Simple status
            $table->timestamp('read_at')->nullable()->after('replied_at');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['admin_reply', 'replied_at', 'read_at']);
        });
    }
};

