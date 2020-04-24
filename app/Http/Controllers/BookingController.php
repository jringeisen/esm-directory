<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Models\User;
use Illuminate\Http\Request;
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

        $user->bookings()->create($request->only(
            'name',
            'email',
            'package',
            'message',
            'requested_date'
        ));

        return response()->json($user);
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
        $booking->update($request->only([
            'name',
            'email',
            'package',
            'message',
            'requested_date'
        ]));

        return response()->json($booking);
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
