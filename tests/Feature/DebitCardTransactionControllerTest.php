<?php

namespace Tests\Feature;

use App\Models\DebitCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DebitCardTransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    // protected User $user;
    // protected DebitCard $debitCard;

    protected function setUp(): void
    {
        // parent::setUp();
        // $this->user = User::factory()->create();
        // $this->debitCard = DebitCard::factory()->create([
        //     'user_id' => $this->user->id
        // ]);
        // Passport::actingAs($this->user);
    }


    // Extra bonus for extra tests :)
}
