<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Requests\ListingRequest;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listings = $request->user()->listings()->get();
        return view('listings', compact('listings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ListingRequest $request)
    {
        $avatar = $request->file('avatar');
        $filename = $request->user()->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();

        Storage::disk('s3')->put('/avatars/' . $filename, file_get_contents($avatar), 'public');

        $listing = $request->user()->listing()->create([
            'name' => $request->name,
            'business_name' => $request->business_name,
            'city' => $request->city,
            'state' => $request->state,
            'description' => $request->description,
            'avatar' => Storage::disk('s3')->url('avatars/' . $filename),
            'starting_package' => $request->starting_package
        ]);

        return response()->json($listing);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        //
    }
}
