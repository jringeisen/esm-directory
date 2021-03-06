<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Listing;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'amount' => 'required',
            'description' => 'required'
        ]);

        $listing = Listing::find($request->listing_id);

        $package = $listing->packages()->create(
            $request->only(['name', 'amount', 'description'])
        );

        return response()->json($package);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $package->update($request->only('name', 'amount', 'description'));

        return response()->json($package);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
    }
}
