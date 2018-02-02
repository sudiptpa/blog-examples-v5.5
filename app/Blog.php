<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Blog
 * @package App
 */
class Blog extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'blogs';

    /**
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * @var array
     */
    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'published_at'];

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    /**
     * @param $date
     */
    public function setPublishedAtAttribute($date)
    {
        $this->attributes['published_at'] = Carbon::parse($date);
    }

    public function getLink()
    {
        return route('app.blog.view', $this->slug);
    }
}
