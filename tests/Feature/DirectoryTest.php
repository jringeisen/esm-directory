<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DirectoryTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Directory page loads.
     *
     * @return void
     */
    public function testTheDirectoryPageLoads()
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertViewIs('guest.directory');
    }

    /**
     * Directory page return 0 listings.
     *
     * @return void
     */
    public function testDirectoryPageAjaxReturnsNoListings()
    {
        $response = $this->get("/", ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonCount(0);
    }

    /**
     * Directory page return total number of listings.
     *
     * @return void
     */
    public function testDirectoryPageAjaxReturnsDatabaseListings()
    {
        $listing = factory(Listing::class)->create();

        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'name' => $listing->name,
            'business_name' => $listing->business_name,
            'city' => $listing->city,
            'state' => $listing->state,
            'description' => $listing->description,
            'avatar' => $listing->avatar,
            'starting_package' => $listing->starting_package,
            'created_at' => $listing->created_at,
            'updated_at' => $listing->updated_at
        ]);

        $response = $this->get("/", ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonCount(1);
    }
}
