<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name', 'email', 'package', 'message', 'requested_date', 'confirmed_on'
    ];

    protected $dates = [
        'requested_date', 'confirmed_on'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
