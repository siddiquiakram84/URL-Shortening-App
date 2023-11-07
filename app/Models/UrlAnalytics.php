<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlAnalytics extends Model
{
    use HasFactory;
}
public function url()
{
    return $this->belongsTo(Url::class);
}
public function shorten($code)
{
    $url = Url::where('code', $code)->firstOrFail();

    // Redirect the user

    UrlAnalytics::create([
        'url_id' => $url->id,
        'user_agent' => request()->header('User-Agent'),
        'ip_address' => request()->ip(),
    ]);

    return redirect($url->original_url);
}
public function showAnalytics($code)
{
    $url = Url::where('code', $code)->firstOrFail();
    $analytics = $url->analytics;

    return view('url.analytics', compact('url', 'analytics'));
}
