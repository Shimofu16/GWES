<?php

use App\Enums\BillingCycleEnum;
use App\Enums\PlanAvailabilityEnum;
use App\Enums\PlanTypeEnum;
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
            $table->double('price');
            $table->unsignedInteger('socials');
            $table->unsignedInteger('duration');
            $table->enum('billing_cycle', BillingCycleEnum::toArray());
            $table->enum('type', PlanTypeEnum::toArray());
            $table->boolean('is_visible')->default(true);
            $table->softDeletes();
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
