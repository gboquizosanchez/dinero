<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Support\Enums\RecurringTypeEnum;
use Taka\Support\Enums\TransactionTypeEnum;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('recurring', static function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type')
                ->comment(implode(',', array_filter(
                    TransactionTypeEnum::values(), static function ($value): bool {
                        return $value !== TransactionTypeEnum::TRANSFER();
                    }))
                )
                ->index();
            $table->string('amount');
            $table->text('description')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->string('recurring_type')
                ->default(RecurringTypeEnum::NONE())
                ->comment(implode(',', RecurringTypeEnum::values()));
            $table->integer('recurring_frequency')
                ->nullable()
                ->comment('based on recurring_type. e.g. every 2 days, every 3 weeks, every 4 months, every 5 years');
            $table->integer('total_recurring_cycles')
                ->nullable()
                ->comment('null means infinite. e.g. 5 means 5 times');
            $table->timestamp('end_at')
                ->nullable()
                ->comment('null means infinite and end_at is until recurring timestamp.');
            $table->timestamps();
        });
    }
};
