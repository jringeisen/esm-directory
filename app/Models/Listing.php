<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'name',
        'business_name',
        'category',
        'city',
        'state',
        'description',
        'avatar',
        'starting_package'
    ];

    protected $with = [
        'packages'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
