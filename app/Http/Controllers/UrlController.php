<?php

namespace App\Http\Controllers;

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
        $data['original_url'] = $request->original_url;
        // $data['shortener_url'] = Str::random(5);
        $unique = false;

        do {
            $randomString = substr(Hash::make(Str::random(40)), 7, 5);

            // Check if the random string already exists in the database
            $exists = Url::where('shortener_url', $randomString)->exists();

            if (!$exists) {
                $unique = true;
            }

        } while (!$unique);

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
        // $validated['shortener_url'] = Str::random(5);
        $unique = false;

        do {
            $randomString = substr(Hash::make(Str::random(40)), 7, 5);

            // Check if the random string already exists in the database
            $exists = Url::where('shortener_url', $randomString)->exists();

            if (!$exists) {
                $unique = true;
            }

        } while (!$unique);

        $data['shortener_url'] = $randomString;
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
        $find = Url::where('shortener_url', $shortener_url)->first();
        return redirect($find->original_url);
    }
}