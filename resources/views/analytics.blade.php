<!-- resources/views/analytics.blade.php -->

<div>
    <p>Access Count: {{ $url->access_count }}</p>
    <p>Last Accessed: {{ $url->last_accessed_at }}</p>
</div>
<h1>Analytics for URL: {{ $url->original_url }}</h1>

<p>Times Used: {{ $analytics->count() }}</p>

<ul>
    @foreach ($analytics as $data)
        <li>User Agent: {{ $data->user_agent }}, IP Address: {{ $data->ip_address }}, Created At: {{ $data->created_at }}</li>
    @endforeach
</ul>
