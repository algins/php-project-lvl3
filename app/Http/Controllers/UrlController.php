<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UrlController extends Controller
{
    private const TABLE = 'urls';

    public function index(): View
    {
        $urls = DB::table(self::TABLE)->get();

        return view('urls.index', compact('urls'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url.name' => 'required|url|max:255',
        ]);

        if ($validator->fails()) {
            flash('Invalid URL')->error();
            return redirect()->route('welcome');
        }

        $urlName = strtolower(parse_url($request->input('url.name'), PHP_URL_HOST));
        $url = DB::table(self::TABLE)->where('name', $urlName)->first();

        if ($url) {
            flash('URL already exists');
            return redirect()->route('urls.show', $url->id);
        }

        $id = DB::table(self::TABLE)->insertGetId([
            'name' => $urlName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        flash('URL successfully added')->success();

        return redirect()->route('urls.show', $id);
    }

    public function show($id): View
    {
        $url = DB::table(self::TABLE)->where('id', $id)->first();

        if (!$url) {
            abort(404);
        }

        return view('urls.show', compact('url'));
    }
}
