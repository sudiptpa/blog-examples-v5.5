<?php

namespace App\Listeners;

use App\Notifications\ArticlePublished;

/**
 * Class BlogEventSubscriber
 * @package App\Listeners
 */
class BlogEventSubscriber
{

    /**
     * Handle blog creating events.
     *
     * @param $blog
     */
    public function onCreated($blog)
    {
        $blog->notify(new ArticlePublished());
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'eloquent.created: App\Blog',
            'App\Listeners\BlogEventSubscriber@onCreated'
        );
    }
}
