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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('Region');
            $table->string('Country');
            $table->string('Item Type');
            $table->string('Sales Channel');
            $table->string('Order Priority');
            $table->date('Order Date');
            $table->string('Order ID');
            $table->date('Ship Date');
            $table->integer('Units Sold');
            $table->decimal('Unit Price', 10, 2);
            $table->decimal('Unit Cost', 10, 2);
            $table->decimal('Total Revenue', 10, 2);
            $table->decimal('Total Cost', 10, 2);
            $table->decimal('Total Profit', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
