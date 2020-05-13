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
        $response = $this->get('/directory');

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
        $response = $this->get("/directory", ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
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

        $this->assertDatabaseHas('listings', $listing->toArray());

        $response = $this->get("/directory", ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonCount(1);
    }
}
