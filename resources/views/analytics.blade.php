<!-- resources/views/analytics.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Analytics for Shortened URL</h1>
    </x-slot>

    <div class="container mx-auto mt-4">
        <div class="bg-white p-4 rounded-md shadow-md">

            @if ($url)
                <div class="text-xl font-bold mb-4">
                    Analytics for: {{ $url->original_url }}
                </div>
            @else
                <div class="text-xl font-bold text-red-500">
                    URL not found
                </div>
            @endif

            <div class="mt-4">
                @if ($url && $url->analytics->isEmpty())
                    <p>No analytics data available yet.</p>
                @elseif ($url)
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full border-collapse border">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border px-4 py-2">Index</th>
                                    <th class="border px-4 py-2">User Agent</th>
                                    <th class="border px-4 py-2">IP Address</th>
                                    <th class="border px-4 py-2">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($url->analytics as $index => $analytics)
                                    <tr class="{{ $index % 2 === 0 ? 'bg-gray-100' : '' }}">
                                        <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="border px-4 py-2">{{ $analytics->user_agent }}</td>
                                        <td class="border px-4 py-2">{{ $analytics->ip_address }}</td>
                                        <td class="border px-4 py-2">{{ $analytics->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
    
</x-app-layout>
