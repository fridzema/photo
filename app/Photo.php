<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Manipulations;

class Photo extends Model implements HasMediaConversions
{
	use HasMediaTrait;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'exif' => 'array',
        'iptc' => 'array'
    ];

    public function registerMediaConversions()
    {
			$this->addMediaConversion('medium')
			->width(280)
			->optimize()
			->nonQueued();

			$this->addMediaConversion('large')
			->width(1140)
			->optimize()
			->queued();
    }

}
