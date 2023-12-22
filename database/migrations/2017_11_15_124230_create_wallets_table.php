<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\Account;
use Taka\Domain\Models\Wallet;
use Taka\Support\Enums\WalletTypeEnum;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create(Wallet::newModelInstance()->getTable(), static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('holder');
            $table->string('name');
            $table->string('slug')->index();
            $table->uuid()->unique();
            $table->foreignIdFor(Account::class)
                ->constrained(Account::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->string('type')->default(WalletTypeEnum::GENERAL());
            $table->string('currency_code')->default('EUR');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->boolean('exclude')->default(false);
            $table->unsignedSmallInteger('statement_day_of_month')->nullable();
            $table->unsignedSmallInteger('payment_due_day_of_month')->nullable();
            $table->string('description')->nullable();
            $table->json('meta')->nullable();
            $table->decimal('balance', 64, 0)->default(0);
            $table->unsignedSmallInteger('decimal_places')->default(2);
            $table->softDeletes();
            $table->timestamps();

            $table->unique([
                'holder_type',
                'holder_id',
                'slug',
            ]);
        });
    }
};
