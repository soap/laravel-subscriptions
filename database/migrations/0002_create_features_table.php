<?php

declare(strict_types=1);

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
        Schema::create(config('subscriptions.tables.features'), function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();

            $table->json('name'); // translatable using spatie/laravel-translatable
            $table->json('description')->nullable();

            $table->boolean('is_consumable')->default(true);
            $table->boolean('is_quota')->default(false);
            $table->boolean('is_postpaid')->default(false);

            $table->integer('renewable_period')->nullable();
            $table->string('renewable_interval')->nullable();
            $table->mediumInteger('sort_order')->unsigned()->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('subscriptions.tables.features'));
    }
};
