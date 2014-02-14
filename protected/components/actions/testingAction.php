<?php

/**
 * test action
 */
class testingAction extends CAction{

    public $someVar = 'someVar';

    /**
     * Runs the action.
     */
    public function run() {
        echo 'this is a test action; ' . $this->someVar;
        var_dump($this->controller->route);
        var_dump($this->id);
    }

}


