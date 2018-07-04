<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

use Auth;
use Session;

class GraphController extends Controller
{
    private $api;
    public function __construct(Facebook $fb)
    {
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->facebookAccounts->token);
            $this->api = $fb;
            return $next($request);
        });
    }

    public function retrieveUserProfile(){
        try {

            $params = "first_name,last_name,age_range,gender";

            $user = $this->api->get('/me?fields=' . $params)->getGraphUser();

            dd($user);

        } catch (FacebookSDKException $e) {

        }

    }
}
