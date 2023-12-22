<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Taka\Domain\Models\User;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Germán Boquizo',
            'email' => 'gboquizo@gmail.com',
        ]);
    }
}
