<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Card;
use App\Models\Deck;
use App\Models\Vote;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'is_admin' => true,
            'password' => bcrypt('password'),
        ]);

        User::factory(10)->create([
            'is_admin' => false,
        ]);
        Card::factory(50)->create();
        Deck::factory(20)->create();
        Vote::factory(50)->create();

        $decks = Deck::all();
        $cards = Card::all();

        foreach ($decks as $deck) {
            $deck->cards()->attach($cards->random(8));
        }
    }
}
