<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserEndpointTests extends TestCase
{
    private $user;

    public function setUp(): void {
        parent::initialize();

        $this->user = User::factory()->create();
    }

    public function test_username()
    {
        $this->get('/api/user/'.$this->user->name)
            ->assertStatus(200);
    }
}
