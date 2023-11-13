<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  UrlAnalytics extends Model
{
    use HasFactory;
    protected $table = 'url_analytics';

    protected $fillable = [
        'url_id',
        'user_agent',
        'ip_address',
        'access_date',
        'access_count'
    ];

    public function url()
    {
        return $this->belongsTo(Url::class);
    }

    public static function trackAnalytics($urlId)
    {
        $urlAnalytics = self::where('url_id', $urlId)
            ->whereDate('access_date', now()->toDateString())
            ->first();

        if (!$urlAnalytics) {
            $urlAnalytics = new UrlAnalytics();
            $urlAnalytics->url_id = $urlId;
            $urlAnalytics->access_date = now()->toDateString();
        }

        $urlAnalytics->user_agent = request()->header('User-Agent');
        $urlAnalytics->ip_address = request()->ip();
        $urlAnalytics->access_count++;
        $urlAnalytics->save();
    }
}
