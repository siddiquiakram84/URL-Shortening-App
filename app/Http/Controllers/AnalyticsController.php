<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\SampleChart;
use App\Models\Url;
use App\Models\Analytics;
use Charts;

class AnalyticsController extends Controller
{
    public function showAnalytics($urlId)
{
    $url = Url::with('analytics')->find($urlId);

    return view('analytics', ['url' => $url]);
}


    public function trackAnalytics($code)
    {
        $url = Url::where('shortener_url', $code)->firstOrFail();

        $Analytics = Analytics::create([
            'url_id' => $url->id,
            'user_agent' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
            'access_date' => now()->toDateString(),
        ]);


        return redirect($url->original_url);
    }
}
