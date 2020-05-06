<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Listing;
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
            ->assertViewIs('users.listings.index');
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
            'category' => 'Family',
            'city' => 'City',
            'state' => 'State',
            'description' => 'Description',
            'avatar' => UploadedFile::fake()->image('photo1.jpg'),
            'starting_package' => 'Starting Package'
        ];

        $response = $this->postJson('/api/listings', $data)
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
            'category' => 'Family',
            'city' => 'City',
            'state' => 'State',
            'description' => 'Description',
            'avatar' => UploadedFile::fake()->image('photo1.jpg'),
            'starting_package' => 'Starting Package'
        ];

        $response = $this->postJson('/api/listings', $data)
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
            'category' => 'Family',
            'city' => 'City',
            'state' => 'FL',
            'description' => 'Description',
            'avatar' => UploadedFile::fake()->create('photo1.pdf'),
            'starting_package' => 'Starting Package'
        ];

        $response = $this->postJson('/api/listings', $data)
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
            'name' => $this->faker->name,
            'business_name' => $this->faker->company,
            'category' => 'Family',
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'description' => $this->faker->sentence,
            'avatar' => UploadedFile::fake()->image('photo1.jpg'),
            'starting_package' => $this->faker->randomFloat(2, 100, 1000)
        ];

        $this->postJson('/api/listings', $data)
            ->assertOk()
            ->assertJson([
                'name' => $data['name'],
                'business_name' => $data['business_name'],
                'category' => $data['category'],
                'city' => $data['city'],
                'state' => $data['state'],
                'description' => $data['description']
            ]);

        $this->assertDatabaseHas('listings', [
            'name' => $data['name'],
            'business_name' => $data['business_name'],
            'category' => $data['category'],
            'city' => $data['city'],
            'state' => $data['state'],
            'description' => $data['description']
        ]);
    }

    /**
     * Authenticated user can update a listing.
     *
     * @return void
     */
    public function testAuthenticatedUserCanUpdateListing()
    {
        $user = $this->authUser();
        
        $listing = factory(Listing::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('listings', $listing->getAttributes());

        $data = [
            'name' => $this->faker->name,
            'business_name' => $this->faker->company,
        ];

        $this->putJson('/api/listings/' . $listing->id, $data)
            ->assertOk()
            ->assertJson($data);

        $this->assertDatabaseHas('listings', $data);
    }

    /**
     * Authenticated user can delete a listing.
     *
     * @return void
     */
    public function testAuthenticatedUserCanDeleteAListing()
    {
        $user = $this->authUser();
        
        $listing = factory(Listing::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('listings', $listing->getAttributes());

        $this->deleteJson('/api/listings/' . $listing->id)
            ->assertOk();

        $this->assertDatabaseMissing('listings', $listing->getAttributes());
    }
}
