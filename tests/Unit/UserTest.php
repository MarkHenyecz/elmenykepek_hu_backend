<?php

namespace Tests\Unit;

use App\Console\Kernel;
use App\Models\Character;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $user;
    
    public function setUp(): void
    {
        parent::initialize();

        $this->user = User::factory()->create();
        $file = File::factory()->create([
            'user_id' => $this->user->id
        ]);
        Character::factory()->create([
            'user_id' => $this->user->id,
            'picture_id' => $file->id,
        ]);
    }
    
    public function test_user()
    {
        $this->assertTrue($this->user->exists());
    }

    public function test_user_files()
    {
        $this->assertTrue($this->user->files()->exists());
    }

    public function test_user_characters()
    {
        $this->assertTrue($this->user->characters()->exists());
    }
}
