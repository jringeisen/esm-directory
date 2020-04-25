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

    /**
     * Authenticated user can update a booking.
     *
     * @return void
     */
    public function testAuthenticatedUserCanUpdateBooking()
    {
        $user = $this->authUser();
        
        $booking = factory(Booking::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'user_id' => $booking->user_id,
            'name' => $booking->name,
            'email' => $booking->email,
            'package' => $booking->package
        ]);

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $this->putJson('/api/bookings/' . $booking->id, $data)
            ->assertOk()
            ->assertJson([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

        $this->assertDatabaseHas('bookings', [
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }

    /**
     * Authenticated user can confirm a booking.
     *
     * @return void
     */
    public function testAuthenticatedUserCanConfirmABooking()
    {
        $user = $this->authUser();
        
        $booking = factory(Booking::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'user_id' => $booking->user_id,
            'name' => $booking->name,
            'email' => $booking->email,
            'package' => $booking->package
        ]);

        $data = [
            'confirmed_on' => now()->toDateTimeString()
        ];

        $this->putJson('/api/bookings/' . $booking->id, $data)
            ->assertOk();

        $this->assertDatabaseHas('bookings', [
            'confirmed_on' => Carbon::parse($data['confirmed_on'])->toDateTimeString(),
        ]);
    }

    /**
     * Authenticated user can send confirmation email.
     *
     * @return void
     */
    public function testAuthenticatedUserCanSentConfirmationEmail()
    {
        Mail::fake();

        $user = $this->authUser();
        
        $booking = factory(Booking::class)->create(['user_id' => $user->id, 'confirmed_on' => now()]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'user_id' => $booking->user_id,
            'name' => $booking->name,
            'email' => $booking->email,
            'package' => $booking->package,
            'confirmed_on' => $booking->confirmed_on->toDateTimeString()
        ]);

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
        $user = $this->authUser();
        
        $booking = factory(Booking::class)->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'name' => $booking->name,
            'email' => $booking->email,
            'package' => $booking->package
        ]);

        $this->deleteJson('/api/bookings/' . $booking->id)
            ->assertOk();

        $this->assertDatabaseMissing('bookings', [
            'name' => $booking->name,
            'email' => $booking->email
        ]);
    }
}
