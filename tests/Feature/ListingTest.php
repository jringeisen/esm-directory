<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Redirects guest to login page when they visit
     * an auth route.
     *
     * @return void
     */
    public function testGuestIsRedirectedToLoginWhenVisitingAuthRoute()
    {
        $this->get('/listings')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     * Authenticated user can view the listings page.
     *
     * @return void
     */
    public function testAuthenticatedUserCanViewTheListingsPage()
    {
        $this->authUser();

        $this->get('/listings')
            ->assertOk()
            ->assertViewIs('authenticated.listings.index');
    }

    /**
     * Empty required fields return status of 422.
     *
     * @return void
     */
    public function testThatEmptyRequiredFieldsReturnStatusOf422()
    {
        $this->authUser();

        $data = [
            'name' => '',
            'business_name' => 'Business Name',
            'city' => 'City',
            'state' => 'State',
            'description' => 'Description',
            'avatar' => UploadedFile::fake()->image('photo1.jpg'),
            'starting_package' => 'Starting Package'
        ];

        $response = $this->postJson('/listings', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * State field validation returns validation error if
     * there are more than 2 characters.
     *
     * @return void
     */
    public function testValidationForStateAbbreviation()
    {
        $this->authUser();

        $data = [
            'name' => 'Name',
            'business_name' => 'Business Name',
            'city' => 'City',
            'state' => 'State',
            'description' => 'Description',
            'avatar' => UploadedFile::fake()->image('photo1.jpg'),
            'starting_package' => 'Starting Package'
        ];

        $response = $this->postJson('/listings', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['state']);
    }

    /**
     * Avatar validation returns 422 if image not a valid mime type.
     *
     * @return void
     */
    public function testValidationForCorrectFileExtension()
    {
        $this->authUser();

        $data = [
            'name' => 'Name',
            'business_name' => 'Business Name',
            'city' => 'City',
            'state' => 'FL',
            'description' => 'Description',
            'avatar' => UploadedFile::fake()->create('photo1.pdf'),
            'starting_package' => 'Starting Package'
        ];

        $response = $this->postJson('/listings', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['avatar']);
    }

    /**
     * Test that a user can create a listing.
     *
     * @return void
     */
    public function testThatAnAuthenticatedUserCanCreateAListing()
    {        
        $this->authUser();

        $data = [
            'name' => 'Name',
            'business_name' => 'Business Name',
            'city' => 'City',
            'state' => 'FL',
            'description' => 'Description',
            'avatar' => UploadedFile::fake()->image('photo1.jpg'),
            'starting_package' => 'Starting Package'
        ];

        $response = $this->postJson('/listings', $data)
            ->assertOk();
    }
}
