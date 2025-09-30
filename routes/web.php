<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('lang/{locale}', function ($locale) {
    if (isset($locale) && array_key_exists($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/votes', function () {
    $votes = DB::table('polls')->where('id', 1)->value('votes');

    return response()->json([
        'success' => true,
        'votes'   => $votes,
    ]);
});

Route::post('vote', function (Request $request) {
    // if ($request->session()->has('voted')) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Вы уже голосовали в этой сессии'
    //     ], 403);
    // }
    DB::table('polls')->where('id', 1)->increment('votes');

    // Сохраняем отметку в сессии
    $request->session()->put('voted', true);

    return response()->json([
        'success' => true,
        'message' => 'Голос засчитан',
        'votes'   => DB::table('polls')->where('id', 1)->value('votes'),
    ]);
});