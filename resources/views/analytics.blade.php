<!-- resources/views/analytics.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Analytics for Short URL: {{ $url->short_url }}</h1>

    <ul>
        @foreach($analyticsData as $analytics)
            <li>Click Time: {{ $analytics->created_at }}</li>
            <!-- Add other analytics information as needed -->
        @endforeach
    </ul>
@endsection
