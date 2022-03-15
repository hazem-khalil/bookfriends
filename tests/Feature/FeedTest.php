<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('only allows authenticated users')
    ->expectGuest()->toBeRedirectedFor('/feed');

it('shows books of friends', function () {
    $user = User::factory()->create();

    $friendOne = User::factory()->create();
    $friendTwo = User::factory()->create();

    $friendOne->books()->attach($bookOne = Book::factory()->create(), [
        'status' => 'WANT_TO_READ',
        'updated_at' => now()->addDay(),
    ]);

    $friendTwo->books()->attach($bookTwo = Book::factory()->create(), [
        'status' => 'READING',
    ]);

    $user->friendsOfMine()->attach($friendOne, [
        'accepted' => true
    ]);

    $user->friendsOfMine()->attach($friendTwo, [
        'accepted' => true
    ]);

    actingAs($user)
        ->get('/feed')
        ->assertSeeInOrder([
            $friendOne->name . ' wants to read ' . $bookOne->title,
            $friendTwo->name . ' is reading ' . $bookTwo->title,
        ]);
});
