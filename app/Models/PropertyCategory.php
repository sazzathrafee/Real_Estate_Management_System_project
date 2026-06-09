<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'description',
    ];

    /**
     * Get the properties for this category
     */
    public function properties()
    {
        return $this->hasMany(Property::class, 'category_id');
    }
}
