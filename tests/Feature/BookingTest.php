<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
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
        $this->get('/bookings')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     * Booking page loads.
     *
     * @return void
     */
    public function testTheBookingPageLoads()
    {
        $this->authUser();

        $response = $this->get('/bookings');

        $response->assertOk()
            ->assertViewIs('users.bookings.index');
    }

    /**
     * Booking page return 0 booking requests.
     *
     * @return void
     */
    public function testBookingsPageAjaxReturnsNoBookingRequests()
    {
        $this->authUser();

        $response = $this->get("/bookings", ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonCount(0);
    }

    /**
     * Empty required fields return status of 422.
     *
     * @return void
     */
    public function testThatEmptyRequiredFieldsReturnStatusOf422()
    {
        $this->authUser();

        $data = [];

        $response = $this->postJson('/api/bookings', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'package', 'requested_date', 'message']);
    }

    /**
     * Test that a client can create a booking.
     *
     * @return void
     */
    public function testThatAnUnauthenticatedClientCanCreateABooking()
    {
        $user = factory(User::class)->create();

        $data = [
            'user_id' => $user->id,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'package' => '2 hour newborn package',
            'requested_date' => '2020-04-24 08:00:00',
            'message' => $this->faker->sentence,
        ];

        $this->postJson('/api/bookings', $data)
            ->assertOk()
            ->assertJson([
                'name' => $data['name'],
                'email' => $data['email'],
                'package' => $data['package']
            ]);

        $this->assertDatabaseHas('bookings', [
            'name' => $data['name'],
            'email' => $data['email'],
            'package' => $data['package']
        ]);
    }
}
