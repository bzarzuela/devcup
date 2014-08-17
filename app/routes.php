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

Route::post('connect', function()
{
  $email = Input::get('email');
  $target = Input::get('target');
  $keyword = Input::get('keyword');

  $job = new Job;
  $job->email = $email;
  $job->target = $target;
  $job->progress = 0;
  $job->keyword = $keyword;
  $job->next_run = date('Y-m-d H:i:s');
  $job->save();

  return Redirect::to('live?id=' . $job->id);
  return View::make('thanks');
});

Route::get('live', function () {
  $id = Input::get('id');

  $job = Job::find($id);
  $influencers = Influencer::where('job_id', '=', $job->id)->get();

  return View::make('live', [
    'job' => $job,
    'influencers' => $influencers,
  ]);
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

  $id = Input::get('id');

  $job = Job::find($id);
  $influencers = Influencer::where('job_id', '=', $job->id)->get();


  return View::make('results_display', [
    'job' => $job,
    'influencers' => $influencers,
  ]);
});