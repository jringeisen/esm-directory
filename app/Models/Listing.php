<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'name', 'business_name', 'city', 'state', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}