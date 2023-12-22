<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\Account;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('goals', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Account::class)
                ->constrained(Account::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->unsignedDecimal('amount', 64, 0)->default(0);
            $table->timestamp('target_date')->nullable();
            $table->string('color')->nullable();
            $table->string('currency_code')->default('EUR');
            $table->timestamps();
        });
    }
};
