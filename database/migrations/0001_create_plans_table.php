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
        Schema::create(config('subscriptions.tables.plans'), function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();

            $table->json('name'); // translatable using spatie/laravel-translatable
            $table->json('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->string('currency', 3)->default('USD');
            $table->decimal('price')->default('0.00');
            $table->decimal('signup_fee')->default('0.00');

            $table->smallInteger('trial_period')->unsigned()->default(0);
            $table->string('trial_interval')->default('day');

            $table->smallInteger('invoice_period')->unsigned()->default(0);
            $table->string('invoice_interval')->default('month');

            $table->smallInteger('grace_period')->unsigned()->default(0);
            $table->string('grace_interval')->default('day');

            $table->tinyInteger('prorate_day')->unsigned()->nullable();
            $table->tinyInteger('prorate_period')->unsigned()->nullable();
            $table->tinyInteger('prorate_extend_due')->unsigned()->nullable();

            $table->smallInteger('active_subscribers_limit')->unsigned()->nullable();
            $table->mediumInteger('sort_order')->unsigned()->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('subscriptions.tables.plans'));
    }
};
