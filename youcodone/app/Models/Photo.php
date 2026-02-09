<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'image',
    ];


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function getImageUrl(): string
    {
        return Storage::url($this->image);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($photo) {
            if (Storage::exists($photo->image)) {
                Storage::delete($photo->image);
            }
        });
    }
}