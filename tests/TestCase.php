<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authUser()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name
        ]);

        $this->actingAs($user);

        return $user;
    }
    
    /**
     * Create a mock for storage
     *
     * @return Storage
     */
    protected function mockStorageDisk($disk = 'mock')
    {
        Storage::extend(
            'mock',
            function () {
                return \Mockery::mock(\Illuminate\Contracts\Filesystem\Filesystem::class);
            }
        );

        Config::set('filesystems.disks.' . $disk, ['driver' => 'mock']);
        Config::set('filesystems.default', $disk);

        return Storage::disk($disk);
    }
}
