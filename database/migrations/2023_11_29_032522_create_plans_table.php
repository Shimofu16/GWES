<?php

use App\Enums\PlanAvailabilityEnum;
use App\Enums\PlanStatusEnum;
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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('slug')->unique();
            $table->boolean('is_visible')->default(true);
            $table->double('price');
            $table->double('discount_price')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->enum('availability',PlanAvailabilityEnum::toArrayAll());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
