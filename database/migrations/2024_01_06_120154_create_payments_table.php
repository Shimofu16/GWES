<?php

use App\Enums\PaymentStatusEnum;
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
            $table->foreignId('subscriber_company_id')->references('id')->on('subscriber_companies');
            $table->foreignId('plan_id')->references('id')->on('plans');
            $table->string('proof_of_payment');
            $table->string('payment_method')->default('GCash');
            $table->double('total');
            $table->date('due_date');
            $table->boolean('latest')->default(false);
            $table->enum('status', PaymentStatusEnum::toArray())->default(PaymentStatusEnum::PENDING); // pending, active, inactive,
            $table->timestamps();
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
