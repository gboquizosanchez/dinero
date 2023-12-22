<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\User;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('accounts', static function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->string('name')->unique()->index();
            $table->foreignIdFor(model: User::class, column: 'owner_id')
                ->constrained(User::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
