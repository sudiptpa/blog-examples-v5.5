<?php

namespace App\Notifications;

use App\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\FacebookPoster\FacebookPosterChannel;
use NotificationChannels\FacebookPoster\FacebookPosterPost;

/**
 * Class ArticlePublished
 * @package App\Notifications
 */
class ArticlePublished extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FacebookPosterChannel::class];
    }

    /**
     * @param $blog
     */
    public function toFacebookPoster($blog)
    {
        return with(new FacebookPosterPost($blog->title))
            ->withLink($blog->getLink());
    }
}
