<?php

use Facebook\Facebook;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('facebook/login', function () {
    $fb = app(Facebook::class);

    $helper = $fb->getRedirectLoginHelper();

    $permissions = ['email', 'public_profile', 'publish_video', 'publish_pages', 'pages_read_engagement', 'pages_manage_posts'];
    $loginUrl = $helper->getLoginUrl('https://local.ciclano.io/login/callback', $permissions);

    echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
});

Route::get('login/callback', function () {
    $fb = app(Facebook::class);

    $helper = $fb->getRedirectLoginHelper();

    try {
        $accessToken = $helper->getAccessToken();
    } catch (Facebook\Exception\ResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (Facebook\Exception\SDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    if (!isset($accessToken)) {
        if ($helper->getError()) {
            header('HTTP/1.0 401 Unauthorized');
            echo "Error: " . $helper->getError() . "\n";
            echo "Error Code: " . $helper->getErrorCode() . "\n";
            echo "Error Reason: " . $helper->getErrorReason() . "\n";
            echo "Error Description: " . $helper->getErrorDescription() . "\n";
        } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
        }
        exit;
    }

    // Logged in
//    echo '<h3>Access Token</h3>';
//    var_dump($accessToken->getValue());

    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();

    // Get the access token metadata from /debug_token
//    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
//    echo '<h3>Metadata</h3>';
//    var_dump($tokenMetadata);

    // Validation (these will throw FacebookSDKException's when they fail)
//    $tokenMetadata->validateAppId(config('services.facebook.app_id'));
    // If you know the user ID this access token belongs to, you can validate it here
    //$tokenMetadata->validateUserId('123');
//    $tokenMetadata->validateExpiration();

    if (!$accessToken->isLongLived()) {
        // Exchanges a short-lived access token for a long-lived one
        try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        } catch (Facebook\Exception\SDKException $e) {
            echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
            exit;
        }

//        echo '<h3>Long-lived</h3>';
//        var_dump($accessToken->getValue());
    }

    $_SESSION['fb_access_token'] = (string)$accessToken;

    try {
        // Returns a `Facebook\Response` object
        $response = $fb->get('/me?fields=id,name,first_name,last_name,email,picture,link', (string)$accessToken);
        $user = $response->getGraphUser();
    } catch (Facebook\Exception\ResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (Facebook\Exception\SDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    try {
        $respponse = $fb->get("/me/accounts?fields=access_token,name,id,link,category&limit=200", (string)$accessToken);
        $accounts = $respponse->getGraphEdge()->asArray();
    } catch (Facebook\Exception\ResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (Facebook\Exception\SDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    dd($user, $accounts);
});
