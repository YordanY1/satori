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
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('needs_invoice')->default(false);
            $table->string('invoice_company_name')->nullable();
            $table->string('invoice_eik')->nullable();
            $table->string('invoice_vat_number')->nullable();
            $table->string('invoice_mol')->nullable();
            $table->string('invoice_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
