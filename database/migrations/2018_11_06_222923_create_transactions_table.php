<?php

declare(strict_types=1);

use Bavix\Wallet\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\Account;
use Taka\Domain\Models\Category;
use Taka\Domain\Models\Wallet;
use Taka\Support\Enums\TransactionTypeEnum;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create(Transaction::newModelInstance()->getTable(), static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('payable');
            $table->foreignIdFor(Account::class)
                ->constrained(Account::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->foreignIdFor(Category::class)
                ->nullable()
                ->constrained(Category::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->foreignIdFor(Wallet::class)
                ->nullable()
                ->constrained(Wallet::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->string('type')
                ->comment(implode(',', TransactionTypeEnum::values()))
                ->index();
            $table->decimal('amount', 64, 0);
            $table->boolean('confirmed');
            $table->text('description')->nullable();
            $table->json('meta')->nullable();
            $table->uuid()->unique();
            $table->timestamp('happened_at')->default(now());
            $table->nullableMorphs('reference');
            $table->softDeletes();
            $table->timestamps();

            $table->index([
                'payable_type',
                'payable_id',
            ], 'payable_type_payable_id_ind');
            $table->index([
                'payable_type',
                'payable_id',
                'type',
            ], 'payable_type_ind');
            $table->index([
                'payable_type',
                'payable_id',
                'confirmed',
            ], 'payable_confirmed_ind');
            $table->index([
                'payable_type',
                'payable_id',
                'type',
                'confirmed',
            ], 'payable_type_confirmed_ind');
        });
    }
};
