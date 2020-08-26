<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Notifications\Notifiable;

class Car extends Model implements HasMedia
{
    use Notifiable;
    use InteractsWithMedia;
    protected $guarded = [];

    public function image()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->width(100)
             ->height(100);
    }
}
