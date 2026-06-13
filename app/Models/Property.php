<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'title',
        'description',
        'price',
        'area_size',
        'bedrooms',
        'bathrooms',
        'garage',
        'property_type',
        'city',
        'division',
        'location',
        'latitude',
        'longitude',
        'status',
        'image',
        'approval_status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area_size' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * Get the seller of this property
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the category of this property
     */
    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'category_id');
    }

    /**
     * Get all images for this property
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class, 'property_id');
    }

    /**
     * Get all visit requests for this property
     */
    public function visitRequests()
    {
        return $this->hasMany(VisitRequest::class, 'property_id');
    }

    /**
     * Get all favorites for this property
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'property_id');
    }

    /**
     * Check if property is approved
     */
    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }

    /**
     * Check if property is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
