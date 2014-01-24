<?php
/**
 * Class MyActiveRecord
 * common behavior for models extending from this class
 */
class MyActiveRecord extends CActiveRecord{

    public function behaviors() {
        return array(
            'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }


}


