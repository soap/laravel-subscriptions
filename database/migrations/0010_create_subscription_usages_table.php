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
        Schema::create(config('subscriptions.tables.subscription_usages'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained(table: config('subscriptions.tables.subscriptions'), indexName: 'subscription_usage_subscription_id_foreign')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('feature_id')->constrained(table: config('subscriptions.tables.features'), indexName: 'subscription_usage_feature_id_foreign')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('used')->unsigned()->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['subscription_id', 'feature_id'], 'subscription_usage_feature_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('subscriptions.tables.subscription_usages'));
    }
};
