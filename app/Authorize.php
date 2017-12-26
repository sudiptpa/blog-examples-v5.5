<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Class Authorize
 * @package App
 */
class Authorize extends Model
{
    /**
     * @var string
     */
    protected $table = 'authorizes';

    /**
     * @var boolean
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $dates = ['authorized_at', 'deleted_at'];

    /**
     * @var string
     */
    protected $fillable = [
        'user_id', 'authorized', 'token', 'ip_address', 'browser', 'os', 'location', 'attempt', 'authorized_at',
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    /**
     * @param $date
     */
    public function setAuthorizedAtAttribute($date)
    {
        $this->attributes['authorized_at'] = Carbon::parse($date);
    }

    /**
     * @return mixed
     */
    public static function active()
    {
        return with(new self)
            ->where('ip_address', Request::ip())
            ->where('authorized', true)
            ->where('authorized_at', '<', Carbon::tomorrow())
            ->first();
    }

    /**
     * @return mixed
     */
    public function resetAttempt()
    {
        $this->update(['attempt' => 0]);

        return $this;
    }

    /**
     * @return mixed
     */
    public function noAttempt()
    {
        return $this->attempt < 1;
    }

    /**
     * @param $token
     */
    public static function validateToken($token = null)
    {
        $query = self::where([
            'token' => $token,
        ])->first();

        if (sizeof($query)) {
            $query->update([
                'authorized' => true,
                'authorized_at' => now(),
            ]);

            return self::active();
        }
    }

    /**
     * @return mixed
     */
    public static function make()
    {
        return self::firstOrCreate([
            'ip_address' => Request::ip(),
            'authorized' => false,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * @return mixed
     */
    public static function inactive()
    {
        $query = self::active();

        return $query ? null : true;
    }
}
