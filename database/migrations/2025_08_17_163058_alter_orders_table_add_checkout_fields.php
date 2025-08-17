<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('public_id')->after('id')->nullable();
            $table->string('order_number')->unique()->after('public_id');
            $table->string('payment_method')->nullable()->after('status');
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            $table->string('currency', 3)->default('BGN')->after('status');
            $table->decimal('subtotal', 10, 2)->default(0)->after('total');
            $table->decimal('discount_total', 10, 2)->default(0)->after('subtotal');
            $table->decimal('shipping_total', 10, 2)->default(0)->after('discount_total');
            $table->decimal('tax_total', 10, 2)->default(0)->after('shipping_total');
            $table->text('notes')->nullable()->after('customer_address');
            $table->string('shipping_method')->nullable()->after('notes');
            $table->string('tracking_number')->nullable()->after('shipping_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'public_id',
                'order_number',
                'payment_method',
                'payment_status',
                'paid_at',
                'currency',
                'subtotal',
                'discount_total',
                'shipping_total',
                'tax_total',
                'notes',
                'shipping_method',
                'tracking_number',
            ]);
        });
    }
};
