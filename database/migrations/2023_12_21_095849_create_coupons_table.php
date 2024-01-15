<?php

use App\Enums\DiscountTypeEnum;
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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->unique(); // Increased string length for flexibility
            $table->enum('discount_type', DiscountTypeEnum::toArray()); // Simplified enum values
            $table->decimal('discount_value', 10, 2)->default(0); // Removed nullable, as it's always applicable
            $table->unsignedInteger('subscription_duration')->nullable(); // Renamed to 'subscription_duration' for clarity
            $table->dateTime('expiry_date')->nullable();
            $table->unsignedInteger('max_redemptions')->nullable(); // Made unsigned for consistency
            $table->integer('redemption_count')->default(0); // Added to track redemptions
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
