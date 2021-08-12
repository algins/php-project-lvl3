<?php

namespace App\Http\Controllers;

use DiDom\Document;
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
        $document = new Document($response->body());

        DB::table('url_checks')->insert([
            'url_id' => $urlId,
            'status_code' => $response->status(),
            'h1' => optional($document->first('h1'))->text(),
            'keywords' => optional($document->first('meta[name="keywords"]'))->attr('content'),
            'description' => optional($document->first('meta[name="description"]'))->attr('content'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        flash('URL successfully checked');

        return redirect()->route('urls.show', $urlId);
    }
}
