<?php

/**
 * HangmanToken class.
 */
class HangmanToken extends CFormModel{
    public $token;

    public function rules() {
        return array(
            array('token', 'required'),
            array('token', 'filter', 'filter' => 'trim'),
            array('token', 'exist', 'className' => 'Hangman', 'attributeName' => 'token'),
        );
    }

    public function attributeLabels() {
        return array(
            'token' => 'Token',
        );
    }

}
