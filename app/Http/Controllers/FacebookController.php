<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\Facebook;

use Log;
use Auth;
use Session;

class FacebookController extends Controller
{
    protected $token = 'EAAHnVyZCI0ZAUBACwRkT7Yq2lGVl3LGyUAiNoZArdMbAaozkeYPm0q9zU0vKuWXiKo7ci9XeJmL2cRf3QVX60cDQPGkNEml04xSJ0uMbzK6FyqjQfsIfG7JTKLzxLA9a51ZA0KfWe6cG257ZClsctt23nBMb6PhgiQxiooANADvxALdjBGbU6iexCUOu9DJRRPWJz5UKC8QsFZCLSI5c0Hi98Uiq4CspkZD';
    public function index()
    {
        // return config('facebook.config');

        // $fb = new Facebook([
        //     'app_id' => env('FACEBOOK_APP_ID'),
        //     'app_secret' => env('FACEBOOK_APP_SECRET'),
        //     'default_graph_version' => env('FACEBOOK_DEFAULT_GRAPH_VERSION'),
        // ]);
        // $this->getOrders('林佳蕙');
        // $this->existName('387264774718630_1496165457161884', '林佳蕙');
        dd(Auth::user()->facebookAccounts);
        return 'test';
    }

    public function callback()
    {

        $fb = new Facebook([
            config('facebook.config'),
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
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
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId(env('FACEBOOK_APP_ID')); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }

            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        // $_SESSION['fb_access_token'] = (string) $accessToken;
    }

    private function getOrders($cust_name) {
        $fb = new Facebook(
            config('facebook.config')
        );

        $response = $fb->get('387264774718630/feed?limit=5', $this->token);
        // $me = $response->getGraphUser();
        // dd($response->getGraphEdge());
        $pagesEdge = $response->getGraphEdge();
        // Only grab 5 pages
        $maxPages = 2;
        $pageCount = 0;

        do {
            foreach ($pagesEdge as $page) {
                // Log::info($page->asArray());
                // Log::info($page['message']);
                $feedId = $page->getField('id');
                Log::info($feedId);
            }
            $pageCount++;
        } while ($pageCount < $maxPages && $pagesEdge = $fb->next($pagesEdge));
    }

    private function existName($feedId, $cust_name) {
        $fb = new Facebook(
            config('facebook.config')
        );

        $response = $fb->get($feedId . '/comments', $this->token);

        do {
            foreach ($pagesEdge as $page) {
                // Log::info($page->asArray());
                // Log::info($page['message']);
                $feedId = $page->getField('id');
                Log::info($feedId);
            }
            $pageCount++;
        } while ($pageCount < $maxPages && $pagesEdge = $fb->next($pagesEdge));
    }
}
