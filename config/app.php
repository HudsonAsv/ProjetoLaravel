<?php

return [

    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'UTC',

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

//     'maintenance' => [
//     'driver' => 'file',
// ],


//     'providers' => [
//     /*
//      * Laravel Framework Service Providers...
//      */
//     Illuminate\Database\DatabaseServiceProvider::class,
//     Illuminate\Auth\AuthServiceProvider::class,
//     Illuminate\Broadcasting\BroadcastServiceProvider::class,
//     Illuminate\Bus\BusServiceProvider::class,
//     Illuminate\View\ViewServiceProvider::class,
//     Illuminate\Cache\CacheServiceProvider::class,
//     Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
//     Illuminate\Filesystem\FilesystemServiceProvider::class,
//     // ...

//     /*
//      * Application Service Providers...
//      */
//     App\Providers\RouteServiceProvider::class,
//     App\Providers\AppServiceProvider::class,
//     App\Providers\AuthServiceProvider::class,
//     App\Providers\EventServiceProvider::class,
// ],
// 'aliases' => [
//         'App' => Illuminate\Support\Facades\App::class,
//         'Artisan' => Illuminate\Support\Facades\Artisan::class,
//         'Auth' => Illuminate\Support\Facades\Auth::class,
//         'Blade' => Illuminate\Support\Facades\Blade::class,
//         'Cache' => Illuminate\Support\Facades\Cache::class,
//         'Config' => Illuminate\Support\Facades\Config::class,
//         'Cookie' => Illuminate\Support\Facades\Cookie::class,
//         'Crypt' => Illuminate\Support\Facades\Crypt::class,
//         'DB' => Illuminate\Support\Facades\DB::class,
//         'Event' => Illuminate\Support\Facades\Event::class,
//         'File' => Illuminate\Support\Facades\File::class,
//         'Hash' => Illuminate\Support\Facades\Hash::class,
//         'Http' => Illuminate\Support\Facades\Http::class,
//         'Lang' => Illuminate\Support\Facades\Lang::class,
//         'Log' => Illuminate\Support\Facades\Log::class,
//         'Mail' => Illuminate\Support\Facades\Mail::class,
//         'Queue' => Illuminate\Support\Facades\Queue::class,
//         'Redirect' => Illuminate\Support\Facades\Redirect::class,
//         'Request' => Illuminate\Support\Facades\Request::class,
//         'Response' => Illuminate\Support\Facades\Response::class,
//         'Route' => Illuminate\Support\Facades\Route::class,
//         'Schema' => Illuminate\Support\Facades\Schema::class,
//         'Session' => Illuminate\Support\Facades\Session::class,
//         'Storage' => Illuminate\Support\Facades\Storage::class,
//         'Str' => Illuminate\Support\Str::class,
//         'URL' => Illuminate\Support\Facades\URL::class,
//         'Validator' => Illuminate\Support\Facades\Validator::class,
//         'View' => Illuminate\Support\Facades\View::class,
//     ],

];
