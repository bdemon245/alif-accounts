<?php

use App\Helpers\TranslateGPT;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('filament.pages.dashboard'));
});
Route::get('gpt/{text}', function ($text) {
    $gpt = new TranslateGPT();
    $response = $gpt->translate($text);
    dd($response->content);
});

Route::get('/toggle-language', function () {
    $isEnglish = App::currentLocale() === 'en';
    if (!$isEnglish) {
        App::setLocale('en');
    } else {
        App::setLocale('bn');
    }

    return back()->with('success', 'Language changed');
});
