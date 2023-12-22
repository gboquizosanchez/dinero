<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Taka\Domain\Models\Account;
use Taka\Domain\Models\User;

final class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        Account::insert([
            [
                'id' => Ulid::generate(),
                'name' => 'Personal',
                'owner_id' => $user->id,
            ],
            [
                'id' => Ulid::generate(),
                'name' => 'Business',
                'owner_id' => $user->id,
            ],
            [
                'id' => Ulid::generate(),
                'name' => 'Family',
                'owner_id' => $user->id,
            ],
        ]);
    }
}
