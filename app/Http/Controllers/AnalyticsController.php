<?php

namespace App\Http\Controllers;

use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use App\Models\Url;
use App\Models\UrlAnalytics;

class AnalyticsController extends Controller
{
    public function showAnalytics($code)
    {
        $url = Url::where('shortener_url', $code)->firstOrFail(); // Updated to use 'shortener_url' column
        $analytics = $url->analytics;

        $chart = Charts::database($analytics, 'bar', 'highcharts')
            ->title('URL Access Analytics')
            ->elementLabel('Access Count')
            ->dimensions(1000, 500)
            ->responsive(true)
            ->groupBy('access_date');

        return view('url.analytics', compact('url', 'analytics', 'chart'));
    }

    public function trackAnalytics($code)
    {
        $url = Url::where('shortener_url', $code)->firstOrFail(); // Updated to use 'shortener_url' column

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
