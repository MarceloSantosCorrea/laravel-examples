<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('facebook/login', function () {
    $fb = new Facebook\Facebook([
        'app_id' => '{app-id}',
        'app_secret' => '{app-secret}',
        'default_graph_version' => 'v2.10',
    ]);

    $helper = $fb->getRedirectLoginHelper();

    $permissions = ['email']; // Optional permissions
    $loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);

    echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
});

Route::get('facebook/callback', function () {
    return view('welcome');
});
