<?php
use Hazzard\Comments\ScriptVariables;

$emoji = config('comments.emoji');
$broadcast = config('comments.broadcast');
$broadcaster = config('broadcasting.default');
$captcha = config('comments.captcha_guest') || config('comments.captcha_auth');
$polyfills = [
    'Promise',
    'Object.assign',
    'Array.from',
    'Array.prototype.includes',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') }}</title>

  <base target="_parent"/>

  <link href="{{ ScriptVariables::mix('app.css', 'vendor/comments') }}" rel="stylesheet">
  {{-- <link href="http://laravel-comments.app/public/app.css" rel="stylesheet"> --}}
</head>
<body>
  <div id="app">
    <comments></comments>
  </div>

  {{ ScriptVariables::render() }}

  @if ($emoji)
    <script src="//twemoji.maxcdn.com/2/twemoji.min.js?2.2.3"></script>
  @endif

  @if ($broadcast && $broadcaster === 'pusher')
    <script src="//js.pusher.com/4.0/pusher.min.js"></script>
  @elseif ($broadcast && $broadcaster === 'redis')
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
  @endif

  @if ($captcha)
    <script src="https://www.google.com/recaptcha/api.js?onload=recaptchaApiLoaded&render=explicit" async></script>
  @endif

  <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>

  <script src="{{ ScriptVariables::mix('app.js', 'vendor/comments') }}"></script>
  {{-- <script src="http://laravel-comments.app/public/app.js"></script> --}}
</body>
</html>
