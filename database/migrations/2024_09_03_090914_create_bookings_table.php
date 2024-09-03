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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('event_id')->nullable()->index();
            $table->string('user_id')->nullable()->index();
            $table->string('processor_id')->nullable()->index();
            $table->string('status')->nullable()->default('pending');
            $table->string('payment_status')->nullable()->default('unpaid');
            $table->decimal('price', 25, 2)->nullable()->default("0.00");
            $table->text('client_remarks')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
