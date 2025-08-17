<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('title')->after('book_id');
            $table->decimal('unit_price', 10, 2)->default(0)->after('title');
            $table->decimal('line_total', 10, 2)->default(0)->after('unit_price');
            $table->string('sku')->nullable()->after('line_total');
            $table->string('isbn')->nullable()->after('sku');
            $table->decimal('tax_rate', 5, 2)->default(0)->after('isbn');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('tax_rate');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'unit_price',
                'line_total',
                'sku',
                'isbn',
                'tax_rate',
                'tax_amount',
            ]);
        });
    }
};
