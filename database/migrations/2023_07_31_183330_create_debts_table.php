<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\Account;
use Taka\Domain\Models\Wallet;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('debts', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->unsignedDecimal('amount')->default(0);
            $table->text('description')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->foreignIdFor(Account::class)
                ->constrained(Account::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->foreignIdFor(Wallet::class)
                ->constrained(Wallet::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->string('color')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
