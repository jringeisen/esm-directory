<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
