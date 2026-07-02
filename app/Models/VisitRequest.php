<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'buyer_id',
        'visit_date',
        'visit_time',
        'message',
        'request_status',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    /**
     * Get the property for this visit request
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    /**
     * Get the buyer who requested this visit
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Check if request is pending
     */
    public function isPending(): bool
    {
        return $this->request_status === 'pending';
    }

    /**
     * Check if request is approved
     */
    public function isApproved(): bool
    {
        return $this->request_status === 'approved';
    }
}
