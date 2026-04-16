<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['album_id', 'image_path', 'caption', 'sort_order'];

    public function album()
    {
        return $this->belongsTo(GalleryAlbum::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}