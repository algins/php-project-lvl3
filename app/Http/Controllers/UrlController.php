<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UrlController extends Controller
{
    public function index(): View
    {
        $urls = DB::table('urls')
            ->leftJoin('url_checks', function ($join) {
                $join
                ->on('urls.id', '=', 'url_checks.url_id')
                ->whereRaw('url_checks.id IN (
                    SELECT MAX(uc.id)
                    FROM url_checks AS uc
                    JOIN urls as u
                    ON u.id = uc.url_id
                    GROUP by u.id
                )');
            })
            ->select('urls.*', 'url_checks.created_at AS last_check', 'url_checks.status_code')
            ->get();

        return view('urls.index', compact('urls'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->input('url'), [
            'name' => 'required|url|max:255',
        ]);

        if ($validator->fails()) {
            flash('Invalid URL')->error();
            return back()->withErrors($validator);
        }

        $urlName = normalize_url($request->input('url.name'));
        $url = DB::table('urls')->where('name', $urlName)->first();

        if ($url) {
            flash('URL already exists');
            return redirect()->route('urls.show', $url->id);
        }

        $id = DB::table('urls')->insertGetId([
            'name' => $urlName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        flash('URL successfully added')->success();

        return redirect()->route('urls.show', $id);
    }

    public function show(int $id): View
    {
        $url = DB::table('urls')->where('id', $id)->first();

        if (!$url) {
            abort(404);
        }

        $checks = DB::table('url_checks')->where('url_id', $id)->latest()->get();

        return view('urls.show', compact('url', 'checks'));
    }
}
