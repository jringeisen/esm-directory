<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\BookingRequest;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json($request->user()->bookings()->get());
        }

        return view('users.bookings.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        $user = User::find($request->user_id);

        $booking = $user->bookings()->create(
            $request->only('name', 'email', 'package', 'message', 'requested_date')
        );

        return response()->json($booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $booking->update($this->mergeData($request));

        $this->sendConfirmationEmail($request, $booking);

        return response()->json($booking);
    }

    /**
     * Merge data from a request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function mergeData($request)
    {
        return array_merge(
            $request->only(['name', 'email', 'package', 'message', 'requested_date']),
            ['confirmed_on' => $request->confirmed_on ? Carbon::now() : null]
        );
    }

    /**
     * Send confirmation email to client.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function sendConfirmationEmail($request, $booking)
    {
        if ($request->has('send_confirmation')) {
            Mail::to($booking->email)->send(new BookingConfirmation($booking));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
    }
}
