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
        Schema::create('subscriber_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->references('id')->on('subscribers');
            $table->foreignId('plan_id')->references('id')->on('plans');
            $table->string('logo')->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('price_range');
            $table->string('description');
            $table->json('socials');
            $table->json('categories'); // array of categories id,  name, slug.
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriber_companies');
    }
};
