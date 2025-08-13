<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
        'postal_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
