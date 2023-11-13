<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\SampleChart;
use App\Models\Url;
use App\Models\UrlAnalytics;
use Charts;

class AnalyticsController extends Controller
{
    public function showAnalytics(Request $request, $code)
    {
        $url = Url::where('shortener_url', $code)->firstOrFail();
        $analytics = $url->analytics;
        dd($analytics);
        if (!$analytics) {
            // If the URL with the given code is not found, return a meaningful message
            return response()->view('errors.404', [], 404);
        }
        // ddd($analytics);
        $dates = $analytics->pluck('access_date')->toArray();
        $count = $analytics->pluck('access_count')->toArray();

        $sample_chart = new SampleChart();
        $sample_chart->labels($dates);
        $sample_chart->dataset('Access Count', 'bar', $count);
        // dd($analytics);
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
