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
        Schema::create(config('subscriptions.tables.plan_features'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained(table: config('subscriptions.tables.plans'), indexName: 'plan_features_plan_id_foreign')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('slug');
            $table->json('name');
            $table->json('description')->nullable();
            $table->string('value')->nullable();
            $table->smallInteger('resettable_period')->unsigned()->default(0);
            $table->string('resettable_interval')->default('month');
            $table->mediumInteger('sort_order')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['plan_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('subscriptions.tables.plan_features'));
    }
};
