<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('about', function()
{
    return View::make('about');
});

Route::get('connect', function()
{
    return View::make('connect');
});

Route::get('pricing', function()
{
    return View::make('pricing');
});

Route::get('contact', function()
{
    return View::make('contact');
});

Route::get('email_template', function()
{
    return View::make('email_template');
});

Route::get('results', function()
{
    return View::make('results');
});

Route::get('results_display', function()
{
    return View::make('results_display');
});