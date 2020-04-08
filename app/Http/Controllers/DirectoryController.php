<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(Listing::all());
        }
    
        return view('guest.directory');
    }
}
