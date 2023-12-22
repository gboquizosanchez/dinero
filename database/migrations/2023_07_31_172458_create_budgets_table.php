<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\Account;
use Taka\Support\Enums\BudgetPeriodEnum;
use Taka\Support\Enums\VisibilityStatusEnum;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('budgets', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedDecimal('amount')->default(0);
            $table->foreignIdFor(Account::class)
                ->constrained(Account::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->string('color')->nullable();
            $table->string('period')->comment(implode(',', BudgetPeriodEnum::values()));
            $table->string('day_of_week')->nullable();
            $table->string('day_of_month')->nullable();
            $table->string('month_of_quarter')->nullable();
            $table->string('month_of_year')->nullable();
            $table->string('status')->default(VisibilityStatusEnum::ACTIVE());
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
