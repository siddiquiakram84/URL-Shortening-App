<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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
        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['title'] = Str::ucfirst($request->title);
        $data['original_url'] = $request->original_url;
        $data['shortener_url'] = substr(base64_encode(Hash::make(now())), 0, 5);
        $created = Url::create($data);

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
        $validated['shortener_url'] = substr(base64_encode(Hash::make(now())), 0, 5);
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

    if ($find) {
        $find->access_count++;
        $find->last_accessed_at = now();
        $find->save();
        return redirect($find->original_url);
    } else {
        // Handle if short URL is not found
        return response()->json(['error' => 'Short URL not found'], 404);

    }
}

public function showAnalytics($id)
{
    $url = Url::find($id);

    return view('analytics', ['url' => $url]);
}


}