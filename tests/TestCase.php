<?php

namespace Tests;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function user($role)
    {
        $user = factory(User::class)->create();
        $assigned_role = factory(Role::class)->create(['name' => $role]);

        $user->assignRole($assigned_role->name);

        $this->assertDatabaseHas('users', $user->getAttributes());

        $this->actingAs($user, 'api');

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
