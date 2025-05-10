<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Order;
use App\Models\Plan;
use App\Models\SkinCondition;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 plans
        $plans = [];
        foreach (range(1, 5) as $i) {
            $plans[] = Plan::create([
                'key' => 'plan_' . $i,
                'name' => 'Plan ' . $i,
                'description' => fake()->sentence(),
                'benefits' => json_encode([
                    fake()->sentence(),
                    fake()->sentence(),
                    fake()->sentence()
                ]),
                'price' => fake()->randomFloat(2, 10, 100)
            ]);
        }

        // Create 30 users
        $users = [];
        foreach (range(1, 30) as $i) {
            $users[] = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'is_admin' => fake()->boolean(10),
                'plan_id' => fake()->randomElement($plans)->id
            ]);
        }

        // Create 30 chats
        $chats = [];
        foreach (range(1, 30) as $i) {
            $chats[] = Chat::create([
                'user_id' => fake()->randomElement($users)->id
            ]);
        }

        // Create 30 messages
        foreach (range(1, 30) as $i) {
            Message::create([
                'chat_id' => fake()->randomElement($chats)->id,
                'user_id' => fake()->randomElement($users)->id,
                'message' => fake()->paragraph(),
                'filenames' => json_encode([])
            ]);
        }

        // Create 30 skin conditions
        foreach (range(1, 30) as $i) {
            SkinCondition::create([
                'name' => ucfirst(fake()->word()),
                'description' => fake()->sentence(),
            ]);
        }

        // Create 30 orders
        foreach (range(1, 30) as $i) {
            Order::create([
                'user_id' => fake()->randomElement($users)->id,
                'transaction_id' => fake()->uuid(),
                'amount' => fake()->randomFloat(2, 20, 150),
                'plan' => fake()->randomElement($plans)->name
            ]);
        }

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin'),
            'is_admin' => 1
        ]);
    }
}
