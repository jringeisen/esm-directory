<?php

namespace Tests\Feature;

use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Only admin can view roles
     *
     * @return void
     * @test
     */
    public function onlyAdminCanViewRoles()
    {
        $this->get('/admin/roles')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     * auth user cannot view roles unless admin.
     *
     * @return void
     * @test
     */
    public function authUserCannotViewRolesUnlessAdmin()
    {
        $this->user('photographer');

        $this->get('/admin/roles')
            ->assertStatus(403);
    }

    /**
     * admin user can view roles.
     *
     * @return void
     * @test
     */
    public function adminUserCanViewRole()
    {
        $this->user('admin');

        $this->get('/admin/roles')
            ->assertOk()
            ->assertViewIs('admin.index');
    }
    
    /**
     * api will return 403 error for anyone other
     * than admin.
     *
     * @return void
     * @test
     */
    public function apiWillReturn403ErrorForAnyoneOtherThanAdmin()
    {
        $this->user('photographer');

        $this->getJson('/api/roles')
            ->assertStatus(403);
    }

    /**
     * api will return results for admin.
     *
     * @return void
     * @test
     */
    public function apiWillReturnResultsForAdmin()
    {
        $this->user('admin');

        $this->getJson('/api/roles')
            ->assertOk();
    }

    /**
     * name attribute is required.
     *
     * @return void
     * @test
     */
    public function nameAttributeIsRequired()
    {
        $this->user('admin');

        $this->postJson('/api/roles', ['name' => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * guard_name attribute is required.
     *
     * @return void
     * @test
     */
    public function guardNameAttributeIsRequired()
    {
        $this->user('admin');

        $this->postJson('/api/roles', ['guard_name' => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['guard_name']);
    }

    /**
     * only admin can create a role.
     *
     * @return void
     * @test
     */
    public function onlyAdminCanCreateARole()
    {
        $this->user('client');

        $data = [
            'name' => 'client',
            'guard_name' => 'web'
        ];

        $this->postJson('/api/roles', $data)
            ->assertStatus(403);
    }

    /**
     * admin can create a role.
     *
     * @return void
     * @test
     */
    public function adminCanCreateARole()
    {
        $this->user('admin');

        $data = [
            'name' => 'client',
            'guard_name' => 'web'
        ];

        $this->postJson('/api/roles', $data)
            ->assertOk();

        $this->assertDatabaseHas('roles', $data);
    }

    /**
     * name field is required on update.
     *
     * @return void
     * @test
     */
    public function nameFieldIsRequiredOnUpdate()
    {
        $this->user('admin');

        $role = factory(Role::class)->create(['name' => 'client']);

        $this->assertDatabaseHas('roles', $role->getAttributes());

        $data = [
            'name' => '',
            'guard_name' => 'web'
        ];

        $this->putJson('/api/roles/' . $role->id, $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * admin can update a role.
     *
     * @return void
     * @test
     */
    public function adminCanUpdateARole()
    {
        $this->user('admin');

        $role = factory(Role::class)->create(['name' => 'client']);

        $this->assertDatabaseHas('roles', $role->getAttributes());

        $data = [
            'name' => 'photographer',
            'guard_name' => 'web'
        ];

        $this->putJson('/api/roles/' . $role->id, $data)
            ->assertOk();

        $this->assertDatabaseHas('roles', $data);
    }
}
