<?php

namespace Tests\Feature;

use Carbon\Carbon;

use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Mail;
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
        $this->user('photographer');

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
        $this->user('photographer');

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
        $this->user('photographer');

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
            ->assertJson($data);

        $this->assertDatabaseHas('bookings', $data);
    }

    /**
     * Authenticated user can update a booking.
     *
     * @return void
     */
    public function testAuthenticatedUserCanUpdateBooking()
    {
        $user = $this->user('photographer');
        
        $booking = factory(Booking::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('bookings', $booking->toArray());

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $this->putJson('/api/bookings/' . $booking->id, $data)
            ->assertOk()
            ->assertJson($data);

        $this->assertDatabaseHas('bookings', $data);
    }

    /**
     * Authenticated user can confirm a booking.
     *
     * @return void
     */
    public function testAuthenticatedUserCanConfirmABooking()
    {
        $user = $this->user('photographer');
        
        $booking = factory(Booking::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('bookings', $booking->toArray());

        $data = [
            'confirmed_on' => now()->toDateTimeString()
        ];

        $response = $this->putJson('/api/bookings/' . $booking->id, $data)
            ->assertOk();

        $this->assertDatabaseHas('bookings', $data);
    }

    /**
     * Authenticated user can send confirmation email.
     *
     * @return void
     */
    public function testAuthenticatedUserCanSentConfirmationEmail()
    {
        Mail::fake();

        $user = $this->user('photographer');
        
        $booking = factory(Booking::class)->create(['user_id' => $user->id, 'confirmed_on' => now()]);

        $this->assertDatabaseHas('bookings', $booking->toArray());

        $data = [
            'send_confirmation' => true
        ];

        $this->putJson('/api/bookings/' . $booking->id, $data)
            ->assertOk();

        Mail::assertSent(BookingConfirmation::class, function ($mail) use ($booking) {
            return $mail->hasTo($booking->email);
        });

        Mail::assertSent(BookingConfirmation::class, 1);
    }

    /**
     * Authenticated user can delete a booking.
     *
     * @return void
     */
    public function testAuthenticatedUserCanDeleteABooking()
    {
        $user = $this->user('photographer');
        
        $booking = factory(Booking::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('bookings', $booking->toArray());

        $response = $this->deleteJson('/api/bookings/' . $booking->id)
            ->assertOk();

        $this->assertDatabaseMissing('bookings', $booking->toArray());
    }
}
