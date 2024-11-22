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
        Schema::create(config('subscriptions.tables.feature_usages'), function (Blueprint $table) {
            $table->id();
            $table->morphs('subscriber');
            $table->foreignId('feature_id')->constrained(table: config('subscriptions.tables.features'), indexName: 'feature_usage_feature_id_foreign')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('used')->unsigned()->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('subscriptions.tables.feature_usages'));
    }
};
