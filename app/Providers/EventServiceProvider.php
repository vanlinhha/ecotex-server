<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\UploadListener;
use UniSharp\LaravelFilemanager\Events\ImageIsUploading;
use UniSharp\LaravelFilemanager\Events\ImageWasUploaded;
use UniSharp\LaravelFilemanager\Events\ImageIsDeleting;
use UniSharp\LaravelFilemanager\Events\ImageIsRenaming;
use UniSharp\LaravelFilemanager\Events\FolderIsRenaming;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen    = [
        'App\Events\Event'      => [
            'App\Listeners\EventListener',
        ],
        ImageIsUploading::class => [
            UploadListener::class,
        ],
        ImageWasUploaded::class => [
            UploadListener::class,
        ],
        ImageIsDeleting::class => [
            UploadListener::class,
        ],
        ImageIsRenaming::class => [
            UploadListener::class,
        ],
        FolderIsRenaming::class => [
            UploadListener::class,
        ],
    ];
//    protected $subscribe = [
//        UploadListener::class
//    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

}
