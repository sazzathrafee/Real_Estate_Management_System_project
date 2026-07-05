<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'property_id',
    ];

    /**
     * Get the buyer who favorited this property
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Get the favorited property
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
