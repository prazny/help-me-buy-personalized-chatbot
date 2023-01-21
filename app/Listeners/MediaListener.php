<?php

namespace App\Listeners;

use App\Jobs\ParseFileJob;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;

class MediaListener
{
    public function handle(MediaHasBeenAdded $event) {
        $media = $event->media;
        $fileSource = $media->model;

        dispatch(new ParseFileJob($fileSource));
    }

}
