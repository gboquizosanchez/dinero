<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\Account;
use Taka\Support\Enums\SpendTypeEnum;
use Taka\Support\Enums\VisibilityStatusEnum;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('categories', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Account::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->comment(implode(',', SpendTypeEnum::values()));
            $table->string('slug')->index();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->integer('order')->default(0);
            $table->string('status')->default(VisibilityStatusEnum::ACTIVE());
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
