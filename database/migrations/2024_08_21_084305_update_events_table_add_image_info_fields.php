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
        Schema::table('events', function (Blueprint $table) {
            $table->string('source')->nullable()->after('location');
            $table->string('filename')->nullable()->after('source');
            $table->text('directory')->nullable()->after('filename');
            $table->text('path')->nullable()->after('directory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['source', 'filename', 'directory', 'path']);
        });
    }
};
