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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable()->unsigned();
            $table->bigInteger('customer_platform_id')->nullable()->unsigned();
            $table->string('amount')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->enum('payment_type', ['cash', 'stripe'])->default('cash');
            $table->bigInteger('payment_type_id')->nullable();
            $table->string('payment_method_types')->nullable();
            $table->enum('payment_status', ['pending', 'processing', 'succeeded', 'requires_payment_method'])->default('pending');
            $table->enum('recharge_status', ['pending', 'done'])->default('pending');
            $table->timestamps();
            $table->integer('recharge_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('recharge_at')->nullable();
            $table->integer('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
