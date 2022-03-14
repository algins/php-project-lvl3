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
            ->leftJoin('url_checks', function ($join): void {
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
            /** @var string $errorMessage */
            $errorMessage = __('views.urls.index.url_invalid');
            flash($errorMessage)->error();
            return back()->withErrors($validator);
        }

        $urlName = normalize_url($request->input('url.name'));
        $url = DB::table('urls')->where('name', $urlName)->first();

        if (!is_null($url)) {
            /** @var string $infoMessage */
            $infoMessage = __('views.urls.show.url_exists');
            flash($infoMessage);
            return redirect()->route('urls.show', $url->id);
        }

        $id = DB::table('urls')->insertGetId([
            'name' => $urlName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /** @var string $successMessage */
        $successMessage = __('views.urls.show.url_added');
        flash($successMessage)->success();

        return redirect()->route('urls.show', $id);
    }

    public function show(int $id): View
    {
        $url = DB::table('urls')->where('id', $id)->first();
        abort_if(!$url, 404);

        $checks = DB::table('url_checks')->where('url_id', $id)->latest()->get();

        return view('urls.show', compact('url', 'checks'));
    }
}
