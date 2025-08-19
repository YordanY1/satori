<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->json('shipping_draft')->nullable()->after('tracking_number');
            $table->string('shipping_provider')->nullable()->after('shipping_draft');
            $table->json('shipping_payload')->nullable()->after('shipping_provider');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_draft', 'shipping_provider', 'shipping_payload']);
        });
    }
};
