<?php

namespace App\Http\Controllers;

use DiDom\Document;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
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
                'title' => optional($document->first('title'))->text(),
                'description' => optional($document->first('meta[name="description"]'))->attr('content'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            /** @var string $successMessage */
            $successMessage = __('views.urls.show.url_checked');
            flash($successMessage);
        } catch (ConnectionException $e) {
            /** @var string $errorMessage */
            $errorMessage = __('views.urls.index.url_read_connection_error');
            flash($errorMessage)->error();
        } catch (RequestException $e) {
            /** @var string $errorMessage */
            $errorMessage = __('views.urls.index.url_read_request_error');
            flash($errorMessage)->error();
        }

        return redirect()->route('urls.show', $urlId);
    }
}
