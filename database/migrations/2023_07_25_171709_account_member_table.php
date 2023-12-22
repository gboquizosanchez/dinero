<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\Account;
use Taka\Domain\Models\User;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('account_member', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Account::class)
                ->constrained(Account::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class)
                ->constrained(User::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
