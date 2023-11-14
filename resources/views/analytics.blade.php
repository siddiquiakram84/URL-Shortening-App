<!-- resources/views/analytics.blade.php -->

<h1>Analytics for Shortened URL</h1>

<div class="card">
    <div class="card-header">
        @if ($url)
            Analytics for: {{ $url->original_url }}
        @else
            URL not found
        @endif
    </div>
    <div class="card-body">
        @if ($url && $url->analytics->isEmpty())
            <p>No analytics data available yet.</p>
        @elseif ($url)
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Agent</th>
                        <th>IP Address</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($url->analytics as $index => $analytics)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $analytics->user_agent }}</td>
                            <td>{{ $analytics->ip_address }}</td>
                            <td>{{ $analytics->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
