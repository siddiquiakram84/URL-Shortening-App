<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Models\Url;
use App\Models\UrlAnalytics;
use Charts;

class AnalyticsController extends Controller
{
    public function showAnalytics($code)
    {
        $url = Url::where('shortener_url', $code)->firstOrFail();
        $analytics = $url->analytics;
        $dates = $analytics->pluck('access_date')->toArray();
        $count = $analytics->pluck('access_count')->toArray();

        $sample_chart = new SampleChart();
        $sample_chart->labels($dates);
        $sample_chart->dataset('Access Count', 'bar', $count);

        return view('urls.analytics', compact('url', 'analytics', 'sample_chart'));
    }

    public function trackAnalytics($code)
    {
        $url = Url::where('shortener_url', $code)->firstOrFail();

        UrlAnalytics::create([
            'url_id' => $url->id,
            'user_agent' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
            'access_date' => now()->toDateString(),
            'access_count' => 1, // Set initial access count to 1
        ]);

        return redirect($url->original_url);
    }
}
