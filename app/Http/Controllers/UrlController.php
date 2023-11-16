<?php

namespace App\Http\Controllers;

use App\Models\Analytics;
use Illuminate\Support\Facades\Hash;
use App\Models\Url;
use App\Models\Click;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('urls.index', [
            'urls' => Url::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'original_url' => 'required|string|max:255',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['title'] = Str::ucfirst($request->title);
        // $data['original_url'] = $request->original_url;
        $originalUrl = $request->original_url;
        // Check if the URL has a scheme (http:// or https://), if not, prepend 'https://'
        if (!parse_url($originalUrl, PHP_URL_SCHEME)) {
            $originalUrl = 'https://' . $originalUrl;
        }
        
        // Check if the URL contains a common domain extension, if not, add ".com"
        $domainExtensions = ['.com', '.in', '.org'];
        $containsExtension = false;

        foreach ($domainExtensions as $extension) {
            if (strpos($originalUrl, $extension) !== false) {
                $containsExtension = true;
                break;
            }
        }

        if (!$containsExtension) {
            $originalUrl .= '.com';
        }
        $data['original_url'] = $originalUrl;
        $maxAttempts = 5;
        $attempts = 0;

        do {
            $randomString = Str::random(5);
            $exists = Url::where('shortener_url', $randomString)->exists();
            $attempts++;
        } while ($exists && $attempts < $maxAttempts);

        if ($attempts === $maxAttempts) {
            return redirect()->back()->with('error', 'Unable to generate a unique short URL after '.$maxAttempts.' attempts. Please try again.');
        }
        // $randomString = Str::random(5);

        $data['shortener_url'] = $randomString;
        Url::create($data);
        return redirect(route('urls.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $url)
    {
        return view('urls.edit', [
            'url' => $url,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $url)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'original_url' => 'required|string|max:255',
        ]);
        $validated['shortener_url'] = Str::random(5);

        $url->update($validated);
        return redirect(route('urls.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url)
    {
        $url->delete();
        return redirect(route('urls.index'));
    }

    public function shortenLink($shortener_url)
    {
    $url = Url::where('shortener_url', $shortener_url)->first();

    // Record analytics data
    $analyticsData = [
        'url_id' => $url->id,
        'user_agent' => request()->header('User-Agent'),
        'ip_address' => request()->ip(),
    ];

    Analytics::create($analyticsData);

    // Redirect to the original URL
    return redirect($url->original_url);
}
    // UrlController.php
public function showAnalytics($urlId)
{
    $url = Url::with('analytics')->find($urlId);

    return view('analytics', ['url' => $url]);
}

}