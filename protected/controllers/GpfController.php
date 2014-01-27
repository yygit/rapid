<?php
Yii::import('application.vendors.google-api-phpclient.*');
require_once(realpath(dirname(__FILE__) . '/../vendors/google-api-phpclient/src/Google_Client.php'));
require_once(realpath(dirname(__FILE__) . '/../vendors/google-api-phpclient/src/contrib/Google_PlusService.php'));

class GpfController extends Controller{
    public $layout = '//layouts/column2';

    public function actionIndex() {
        $authUrl = '';
        $session = Yii::app()->session;
        $client = new Google_Client();
        $client->setApplicationName("Google+ Comic Book News Feed");
        // Visit https://code.google.com/apis/console to generate your oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
        $client->setClientId('873878906496.apps.googleusercontent.com');
        $client->setClientSecret('ThSuhG1wWqVkRclk7X0rbiBy');
        $client->setRedirectUri('http://localhost/rapid/gpf/index');
        $client->setDeveloperKey('DEVELOPER_KEY');

        $plus = new Google_PlusService($client);
        if (isset($_REQUEST['logout'])) {
            unset($session['access_token']);
        }

        if (isset($_GET['code'])) {
            $client->authenticate();
            $session['access_token'] = $client->getAccessToken();
            header('Location: http://' . $_SERVER['HTTP_HOST'] .
            $_SERVER['PHP_SELF']);
        }
        if (isset($session['access_token'])) {
            $client->setAccessToken($session['access_token']);
        }
        $activityList = array();
        if ($client->getAccessToken()) {
            $optParams = array('maxResults' => 100);
            $activities = $plus->activities->search('#comicbooks');


            foreach ($activities['items'] as $activity) {
                $activityListItem = array();
                $activityListItem['url'] = filter_var($activity['url'], FILTER_VALIDATE_URL);
                $activityListItem['title'] = filter_var($activity['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                $activityListItem['content'] = $activity['object']['content'];
                $activityListItem['images'] = array();
                if (isset($activity['object']['attachments'])) {
                    foreach ($activity['object']['attachments'] as $attachment) {
                        if ($attachment['objectType'] === 'photo') {
                            $activityListItem['images'][] = $attachment['image']['url'];
                        }
                    }
                }
                $activityList[] = $activityListItem;
            }
            $session['access_token'] = $client->getAccessToken();
        } else {
            $authUrl = $client->createAuthUrl();
        }
        $this->render('index', array('activityList' => $activityList, 'authUrl' => $authUrl));
    }
}
