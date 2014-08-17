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

  Session::set('job_id', $job->id);

  return Redirect::to('live');
});

Route::get('live', function () {
  $job = Job::find(Session::get('job_id'));

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
  $job = Job::find(Session::get('job_id'));
  return View::make('results', [
    'job' => $job,
  ]);
});

Route::get('results_display', function()
{

  $job = Job::find(Session::get('job_id'));
  $influencers = Influencer::where('job_id', '=', $job->id)->get();

  $prefix = Config::get('app.redis_prefix');
  $redis = Redis::connection();

  foreach ($influencers as $rec) {
    $user = json_decode($redis->get($prefix . ':user:' . $rec['user_id']), true);
    $rec->photo = $user['profile_image_url'];
    $rec->followers_count = $user['followers_count'];
  }

  return View::make('results_display', [
    'job' => $job,
    'influencers' => $influencers,
  ]);
});
