<?php

class HangmanController extends GameController{
    public $gameName = 'hangman';

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            'test' => array(
                'class' => 'application.components.actions.testingAction',
                'someVar' => 'this is some variable',
            ),
        );
    }

    public function actionCreate() {
        $titles = $this->getTitlesList();
        $this->refineTitles($titles);

        $hangman = new Game();
        $hangman->target = strtoupper($titles[mt_rand(0, count($titles) - 1)]);
        $this->generateToken($hangman);
        $hangman->game_type_id = GameType::getTypeId($this->gameName);
        if ($hangman->save()) {
            $this->redirect(array('play', 'token' => $hangman->token));
        } else {
            $this->errorAndEnd('create', print_r($hangman->getErrors(), true));
        }
    }

    public function actionPlay() {
        $hangman = $this->evalTokenAndGetGame();
        $title = mb_strtoupper($hangman->target, 'UTF-8');
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


}
