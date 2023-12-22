<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taka\Domain\Models\Budget;
use Taka\Domain\Models\Category;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('budget_category', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Budget::class)
                ->constrained(Budget::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->foreignIdFor(Category::class)
                ->constrained(Category::newModelInstance()->getTable())
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
