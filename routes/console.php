<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('install', function () {

    $this->comment(\Illuminate\Support\Facades\Artisan::call('migrate:fresh'));
    $this->comment(\Illuminate\Support\Facades\Artisan::call('db:seed'));
    $this->comment(\Illuminate\Support\Facades\Artisan::call('clean'));

})->describe('Install The App');



Artisan::command('clean', function () {

    // $this->comment(\Illuminate\Support\Facades\Artisan::call('clear'));
    $this->comment(\Illuminate\Support\Facades\Artisan::call('config:clear'));
    $this->comment(\Illuminate\Support\Facades\Artisan::call('cache:clear'));
    $this->comment(\Illuminate\Support\Facades\Artisan::call('view:clear'));
    $this->comment(\Illuminate\Support\Facades\Artisan::call('route:clear'));
    $this->comment(\Illuminate\Support\Facades\Artisan::call('clear-compiled'));
    $this->comment(\Illuminate\Support\Facades\Artisan::call('debugbar:clear'));
    \Illuminate\Support\Facades\Storage::disk('logs')->delete('laravel.log');
    \Illuminate\Support\Facades\Storage::disk('public')->deleteDirectory('attachments');

})->describe('Clear all App');