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
                $controllerId = Game::getControllerId($model);
                $this->redirect(array($controllerId . '/play', 'token' => $model->token));
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
     * @return Game
     */
    protected function evalTokenAndGetGame() {
        $token = Yii::app()->request->getQuery('token');
        if (empty($token)) {
            $this->redirect(array('token'));
        }
        $game = Game::model()->with('book', 'author')->findByAttributes(array('token' => $token));
        if (empty($game)) {
            $this->errorAndEnd('play', 'Invalid token.');
        }
        return $game;
    }
}
