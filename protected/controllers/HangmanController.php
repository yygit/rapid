<?php

class HangmanController extends Controller{
    private $win = false;
    private $lose = false;
    private $message = '';

    public function actionCreate() {
        $titles = $this->getTitlesList();
        $this->refineTitles($titles);

        $hangman = new Hangman;
        $hangman->title = strtoupper($titles[mt_rand(0, count($titles) - 1)]);
        $this->generateToken($hangman);
        if ($hangman->save()) {
            $this->redirect(array('play', 'token' => $hangman->token));
        } else {
            $this->errorAndEnd('create', print_r($hangman->getErrors(), true));
        }
    }

    public function actionPlay() {
        $token = Yii::app()->request->getQuery('token');
        if (empty($token)) {
            $this->redirect(array('token'));
        }
        $hangman = Hangman::model()->findByAttributes(array('token' => $token));
        if (empty($hangman)) {
            $this->errorAndEnd('play', 'Invalid token.');
        }
        $title = mb_strtoupper($hangman->title, 'UTF-8');

        $this->assessGuess($hangman, $title);

        $guessed = array();
        foreach (preg_split('//u', $hangman->guessed, 0, PREG_SPLIT_NO_EMPTY) as $letter) {
            $guessed[$letter] = 1;
        }
        $maskedTitle = '';
        foreach (preg_split('//u', $title, 0, PREG_SPLIT_NO_EMPTY) as $letter) {
            if (!isset($guessed[$letter]) && self::ctype_char_utf($letter)) {
                $maskedTitle .= '_ ';
            } else {
                $maskedTitle .= $letter . ' ';
            }
        }
        $maskedTitle = preg_replace('/ /', '&nbsp;', $maskedTitle);
        $dataArr = array(
//            'model' => $hangman,
            'maskedTitle' => $maskedTitle,
            'guessed' => $hangman->guessed,
            'fails' => $hangman->fails,
            'win' => $this->win,
            'lose' => $this->lose,
            'title' => $title,
            'token' => $hangman->token,
            'message' => $this->message,
        );
        $this->render('play', array('dataArr' => $dataArr));
    }


    public function actionToken() {
        $model = new HangmanToken('token');
        // uncomment the following code to enable ajax-based validation
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'hangman-token-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['HangmanToken'])) {
            $model->attributes = $_POST['HangmanToken'];
            if ($model->validate()) {
                $this->redirect(array('play', 'token' => $model->token));
            }
        }
        $this->render('token', array('model' => $model));
    }

// Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */

    /**
     * @param $action string
     * @param $error string
     */
    private function errorAndEnd($action, $error) {
        $this->render($action, array('error' => $error));
        Yii::app()->end();
    }

    private function hangmanToken() {
        $charset = '0123456789abcdef';
        $token = '';
        $charArr = preg_split('//u', $charset, 0, PREG_SPLIT_NO_EMPTY);
        for ($count = 0; $count < 32; $count++) {
            $token .= $charArr[mt_rand(0, count($charArr) - 1)];
        }
        return $token;
    }

    /**
     * refine titles array
     * @param $titles array
     */
    private function refineTitles(&$titles) {
        if ((!is_array($titles)) || (count($titles) == 0)) {
            $this->errorAndEnd('create', 'No titles found fetching from the given URL');
        }
        for ($count = 0; $count < count($titles); $count++) {
            if (strlen($titles[$count]) < 8) {
                unset($titles[$count]);
            }
        }
        if (count($titles) < 1) {
            $this->errorAndEnd('create', 'No suitable titles found in database.');
        }
        $titles = array_merge($titles);
    }

    /**
     * @param $hangman Hangman
     */
    private function generateToken($hangman) {
        $randCount = 0;
        do {
            if ($randCount > 5) { //Even one duplicate is *highly* unlikely (1 in 2^128 if mt_rand were truly random)
                $this->errorAndEnd('create', 'Token generation appears to be broken.');
            }
            $hangman->token = $this->hangmanToken();
            $randCount++;
        } while ((Hangman::model()->findByAttributes(array('token' => $hangman->token))) != null); // check if the generated token is already present in DB (from different games)
    }

    /**
     * @param $guesses string
     * @param $title string
     * @return bool
     */
    private function assessWin($guesses, $title) {
        $guessArr = array();
        foreach (preg_split('//u', mb_strtoupper($guesses, 'UTF-8'), 0, PREG_SPLIT_NO_EMPTY) as $letter) {
            $guessArr[$letter] = true;
        }
        foreach (preg_split('//u', mb_strtoupper($title, 'UTF-8'), 0, PREG_SPLIT_NO_EMPTY) as $letter) {
            if (!isset($guessArr[$letter]) && self::ctype_char_utf($letter)) {
                return false;
            }
        }
        return true;
    }

    /**
     * guess assessment - whether won or lost or neither. generate message;
     * @param $hangman Hangman
     * @param $title string
     * @throws CDbException
     */
    private function assessGuess($hangman, $title) {
        if ($hangman->fails > 5) {
            $this->lose = true;
        } else {
            $this->win = $this->assessWin($hangman->guessed, $hangman->title);
            $getGuess = Yii::app()->request->getQuery('guess');
            if (!($this->assessWin($hangman->guessed, $hangman->title)) && $getGuess) {
                $guess = mb_strtoupper($getGuess, 'UTF-8');
                if (mb_strlen($guess, 'UTF-8') == 1 && self::ctype_char_utf($guess) && !mb_stristr($hangman->guessed, $guess, false, 'UTF-8')) {
                    if (!strstr($title, $guess)) {
                        $hangman->fails++;
                        if ($hangman->fails > 5) {
                            $this->lose = true;
                        }
                    }
                    $hangman->guessed .= $guess;
                    $guessed = preg_split('//u', $hangman->guessed, 0, PREG_SPLIT_NO_EMPTY);
                    sort($guessed);
                    $hangman->guessed = implode($guessed);
                    if (!$hangman->save()) {
                        throw new CDbException('cannot save: ' . print_r($hangman->getErrors(), 1));
                    }
                    $this->win = $this->assessWin($hangman->guessed, $hangman->title);
                } else {
                    $this->message .= "Invalid guess. Please enter a single letter that hasn't already been guessed.";
                }
            }
        }
    }

    /**
     * retrieves titles list, returns json decoded
     * @param string $url
     * @return array|mixed
     */
    private function getTitlesList($url = '/book/titlelist') {
        $request = Yii::app()->request;
        $jsonUrl = $request->hostInfo . $request->baseUrl . $url;
        $sessionName = Yii::app()->session->sessionName;
        $strCookie = $sessionName . '=' . $_COOKIE[$sessionName] . '; path=/';
        session_write_close();
        $ch = curl_init();
//        $f = fopen(Yii::app()->basePath . '\runtime\actionCreate-request.txt', 'w');
        $options = array(
            CURLOPT_URL => $jsonUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_VERBOSE => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_COOKIE => $strCookie,
//            CURLOPT_STDERR => $f,
        );
        curl_setopt_array($ch, $options);
        $titles = json_decode(curl_exec($ch));
//        fclose($f);
        curl_close($ch);
        return $titles;
    }


    /**
     * Check for alphabetic character, utf safe, see http://stackoverflow.com/questions/961573/utf-8-isalpha-in-php
     * @param $char string
     * @return bool
     */
    public static function ctype_char_utf($char) {
        if (preg_match('/^\p{L}+$/u', $char)) {
            return true;
        } else {
            return false;
        }
    }
}
