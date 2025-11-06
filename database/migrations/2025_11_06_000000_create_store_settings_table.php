<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->default('Pangara Store');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('notif_email')->default(true);
            $table->boolean('notif_stock')->default(true);
            $table->boolean('notif_daily_report')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
