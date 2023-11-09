<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\UrlAnalytics;

class SampleChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $analyticsData = UrlAnalytics::all(); // Fetch your analytics data here

        $dates = $analyticsData->pluck('access_date');
        $accessCounts = $analyticsData->pluck('access_count');

        $this->labels($dates);
        $this->dataset('Access Counts', 'line', $accessCounts);
    }
}
