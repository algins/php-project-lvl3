<?php

namespace App\Http\Controllers;

use DiDom\Document;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    public function store(int $urlId): RedirectResponse
    {
        /** @var mixed $url */
        $url = DB::table('urls')->where('id', $urlId)->first();

        if (is_null($url)) {
            /** @var string $errorMessage */
            $errorMessage = __('views.urls.index.url_not_found');
            flash($errorMessage)->error();
            return redirect()->route('urls.show', $urlId);
        }

        try {
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
        } catch(Exception $e) {
            /** @var string $errorMessage */
            $errorMessage = __('views.urls.index.url_read_error');
            flash($errorMessage)->error();
            return redirect()->route('urls.show', $urlId);
        }

        /** @var string $successMessage */
        $successMessage = __('views.urls.show.url_checked');
        flash($successMessage);

        return redirect()->route('urls.show', $urlId);
    }
}
