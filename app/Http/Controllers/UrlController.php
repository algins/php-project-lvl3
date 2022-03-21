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
        $urls = DB::table('urls')->paginate();

        $urlChecks = DB::table('url_checks')
            ->latest()
            ->get()
            ->unique('url_id')
            ->keyBy('url_id');

        return view('urls.index', compact('urls', 'urlChecks'));
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

        $urlName = strtolower($request->input('url.name'));

        /** @var mixed $url */
        $url = DB::table('urls')->where('name', $urlName)->first();

        if (is_null($url)) {
            $id = DB::table('urls')->insertGetId([
                'name' => $urlName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            /** @var string $successMessage */
            $successMessage = __('views.urls.show.url_added');
            flash($successMessage)->success();
        } else {
            $id = $url->id;
            /** @var string $infoMessage */
            $infoMessage = __('views.urls.show.url_exists');
            flash($infoMessage);
        }

        return redirect()->route('urls.show', $id);
    }

    public function show(int $id): View
    {
        $url = DB::table('urls')->where('id', $id)->first();
        abort_unless(isset($url), 404);

        $checks = DB::table('url_checks')->where('url_id', $id)->latest()->get();

        return view('urls.show', compact('url', 'checks'));
    }
}
