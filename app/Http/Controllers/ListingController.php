<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Support\Str;
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
    public function index()
    {
        return view('authenticated.listings.index');
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

        $listing = $request->user()->listings()->create([
            'name' => $request->name,
            'business_name' => $request->business_name,
            'category' => $request->category,
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
        $listing->update($request->all());

        return response()->json($listing);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        $dir = Str::after($listing->avatar, '.com');

        if (Storage::disk('s3')->exists($dir)) {
            Storage::disk('s3')->delete($dir);
        }

        $listing->delete();
    }
}
