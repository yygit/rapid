<?php

class GameController extends Controller{
    protected $win = false;
    protected $lose = false;
    protected $message = '';

    /**
     * accept and validate token entered through the form, redirect to 'play' action
     */
    public function actionToken() {
        $model = new TokenForm('token');
        // uncomment the following code to enable ajax-based validation
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'game-token-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['TokenForm'])) {
            $model->attributes = $_POST['TokenForm'];
            if ($model->validate()) {
                $this->redirect(array('play', 'token' => $model->token));
            }
        }
        $this->render('//game/token', array('model' => $model));
    }


    /**
     * @param $action string
     * @param $error string
     */
    protected function errorAndEnd($action = '//game/error', $error) {
        $action = empty($action) ? '//game/error' : $action;
        header("HTTP/1.0 500 Internal Server Error");
        $this->render($action, array('error' => $error));
        Yii::app()->end();
    }

    /**
     * generate a token string
     * @return string
     */
    protected function gameToken() {
        $charset = '0123456789abcdef';
        $token = '';
        $charArr = preg_split('//u', $charset, 0, PREG_SPLIT_NO_EMPTY);
        for ($count = 0; $count < 32; $count++) {
            $token .= $charArr[mt_rand(0, count($charArr) - 1)];
        }
        return $token;
    }


    /**
     * generates a token for the new game and verify its uniqueness
     * @param $model CActiveRecord
     */
    protected function generateToken(CActiveRecord $model) {
        $randCount = 0;
        do {
            if ($randCount > 5) { //Even one duplicate is *highly* unlikely (1 in 2^128 if mt_rand were truly random)
                $this->errorAndEnd('create', 'Token generation appears to be broken.');
            }
            $model->token = $this->gameToken();
            $randCount++;
        } while ((Game::model()->findByAttributes(array('token' => $model->token))) != null); // check if the generated token is already present in DB (from different games)
    }

    /**
     * refine titles array
     * @param $titles array
     */
    protected function refineTitles(&$titles) {
        if ((!is_array($titles)) || (count($titles) == 0)) {
            $this->errorAndEnd('create', 'No titles found fetching from the given URL');
        }
        for ($i = 0; $i < count($titles); $i++) {
            if (strlen($titles[$i]) < 8) {
                unset($titles[$i]);
            }
        }
        if (count($titles) < 1) {
            $this->errorAndEnd('create', 'No suitable titles found in database.');
        }
        $titles = array_merge($titles);
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
     * @param $hangman Game
     * @param $title string
     * @throws CDbException
     */
    protected function assessGuess($hangman, $title) {
        if ($hangman->fails > 5) {
            $this->lose = true;
        } else {
            $this->win = $this->assessWin($hangman->guessed, $hangman->target);
            $getGuess = Yii::app()->request->getQuery('guess');
            if (!($this->assessWin($hangman->guessed, $hangman->target)) && $getGuess) {
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
                    $this->win = $this->assessWin($hangman->guessed, $hangman->target);
                } else {
                    $this->message .= "Invalid guess. Please enter a single letter that hasn't already been guessed.";
                }
            }
        }
    }

    /**
     * @return Game
     */
    protected function evalTokenAndGetGame() {
        $token = Yii::app()->request->getQuery('token');
        if (empty($token)) {
            $this->redirect(array('token'));
        }
        $game = Game::model()->findByAttributes(array('token' => $token));
        if (empty($game)) {
            $this->errorAndEnd('play', 'Invalid token.');
        }
        return $game;
    }
}
