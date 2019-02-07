<?php

namespace App\Http\Controllers;

use App\Minimizer;
use Illuminate\Http\Request;
use App\Classes\ShortUrlGenerator;


class MinimizerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('create', ['url' => ShortUrlGenerator::instance()->addGetShortUrlByOriginalUrl($request->url)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $hash
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(string $hash)
    {
        return redirect(ShortUrlGenerator::instance()->getOriginUrl($hash)->originalUrl, 302, ['Cache-Control: private, no-cache']);
    }

    /**
     * Show the form for editing the specified resource.
     *s
     * @param  \App\Minimizer  $minimizer
     * @return \Illuminate\Http\Response
     */
    public function edit(Minimizer $minimizer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Minimizer  $minimizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Minimizer $minimizer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Minimizer  $minimizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Minimizer $minimizer)
    {
        //
    }
}
