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
    $parties = [
        'হেলেন ট্রেড' => [
            'name' => 'BHL',
            'address' => 'জগদীশমোড়, হবীগঞ্জ'
        ],
        'প্রাণ RFL' => [
            'name' => null,
            'address' => 'অলিপুর, হবীগঞ্জ'
        ],
        'প্রাণ বেভারেজ লিঃ' => [
            'name' => null,
            'address' => 'গোড়াশাল'
        ],
        'তৌহিদী লাইন্স' => [
            'name' => '',
            'address' => 'KEPZ'
        ],
        'জয়নাল কার্গো' => [
            'name' => '',
            'address' => ''
        ],
        'করিম ক্যারিয়ার' => [
            'name' => '',
            'address' => ''
        ],
        'চারু সিরামিক্স লিঃ' => [
            'name' => null,
            'address' => 'হবীগঞ্জ'
        ],
        'গ্রেট ওয়াল' => [
            'name' => 'গ্রেট ওয়াল সিরামিক্স লিঃ',
            'address' => 'মাওনা'
        ],
    ];
    foreach ($parties as $key => $party) {
        dd($key);
    }
    return view('welcome');
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
