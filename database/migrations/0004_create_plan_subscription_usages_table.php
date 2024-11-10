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
        Schema::create(config('subscriptions.tables.plan_subscription_usage'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_subscription_id')->constrained(table: config('subscriptions.tables.plan_subscriptions'), indexName: 'subscription_usage_subscription_id_foreign')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('plan_feature_id')->constrained(table: config('subscriptions.tables.plan_features'), indexName: 'subscription_usage_feature_id_foreign')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->smallInteger('used')->unsigned();
            $table->timestamp('valid_until')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['plan_subscription_id', 'plan_feature_id'], 'subscription_usage_feature_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('subscriptions.tables.plan_subscription_usage'));
    }
};
