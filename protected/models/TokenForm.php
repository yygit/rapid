<?php

/**
 * TokenForm class.
 */
class TokenForm extends CFormModel{
    public $token;

    public function rules() {
        return array(
            array('token', 'required'),
            array('token', 'filter', 'filter' => 'trim'),
            array('token', 'exist', 'className' => 'Game', 'attributeName' => 'token'),
        );
    }

    public function attributeLabels() {
        return array(
            'token' => 'Token',
        );
    }

}
