<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    public function store(int $urlId): RedirectResponse
    {
        $url = DB::table('urls')->where('id', $urlId)->first();

        if (!$url) {
            flash('URL not found')->error();
            return redirect()->route('urls.show', $urlId);
        }

        $response = Http::get($url->name);

        DB::table('url_checks')->insert([
            'url_id' => $urlId,
            'status_code' => $response->status(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        flash('URL successfully checked');

        return redirect()->route('urls.show', $urlId);
    }
}
