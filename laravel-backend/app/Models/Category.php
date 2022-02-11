<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the parent imageable model (user or post).
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
