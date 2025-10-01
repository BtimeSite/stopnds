<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

Route::get('lang/{locale}', function ($locale) {
    if (isset($locale) && array_key_exists($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();
});

Route::get('/', function (Request $request) {
    $ip = $request->ip();
    $voted = false;
    if (Cache::has("voted:{$ip}") || $request->session()->has('voted')) {
        $voted = true;
    }
    $locale = App::getLocale() == 'ru' ? 'kk' : 'ru';
    return view('welcome', compact('voted', 'locale'));
});

Route::get('/votes', function () {
    $poll = DB::table('polls')->where('id', 1)->first();

    return response()->json([
        'success'   => true,
        'votes_yes' => $poll->votes_yes ?? 0,
        'votes_no'  => $poll->votes_no ?? 0,
    ]);
});

Route::post('vote', function (Request $request) {
    $ip = $request->ip();
    $choice = $request->input('choice');

    if (Cache::has("voted:{$ip}") || $request->session()->has('voted')) {
        return response()->json([
            'success' => false,
            'message' => 'Вы уже голосовали в этой сессии'
        ]);
    }

    if (!in_array($choice, ['yes', 'no'])) {
        return response()->json(['success' => false, 'message' => 'Неверный выбор'], 400);
    }

    DB::table('polls')->where('id', 1)->increment("votes_{$choice}");

    Cache::put("voted:{$ip}", true, now()->addHour());

    $poll = DB::table('polls')->where('id', 1)->first();

    return response()->json([
        'success'   => true,
        'votes_yes' => $poll->votes_yes,
        'votes_no'  => $poll->votes_no,
    ]);
});