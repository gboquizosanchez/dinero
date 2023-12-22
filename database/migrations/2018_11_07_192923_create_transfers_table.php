<?php

declare(strict_types=1);

use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Models\Transfer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\Account;
use Taka\Support\Enums\TransferStatusEnum;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create(Transfer::newModelInstance()->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Account::class)
                ->constrained(Account::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->morphs('from');
            $table->morphs('to');
            $table->string('status')
                ->comment(implode(',', TransferStatusEnum::values()))
                ->default(TransferStatusEnum::TRANSFER());
            $table->string('status_last')
                ->comment(implode(',', TransferStatusEnum::values()))
                ->nullable();

            $table->unsignedBigInteger('deposit_id');
            $table->unsignedBigInteger('withdraw_id');

            $table->decimal('discount', 64, 0)->default(0);

            $table->decimal('fee', 64, 0)->default(0);

            $table->uuid()->unique();
            $table->text('description')->nullable();
            $table->timestamp('happened_at')->default(now());
            $table->softDeletes();
            $table->timestamps();

            $transactionTable = Transaction::newModelInstance()->getTable();

            $table->foreign('deposit_id')
                ->references('id')
                ->on($transactionTable)
                ->onDelete('cascade');

            $table->foreign('withdraw_id')
                ->references('id')
                ->on($transactionTable)
                ->onDelete('cascade');
        });
    }
};
