<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UrlCheckController extends Controller
{
    public function store(int $urlId): RedirectResponse
    {
        DB::table('url_checks')->insert([
            'url_id' => $urlId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        flash('URL successfully checked');

        return redirect()->route('urls.show', $urlId);
    }
}
