<?php

class SelectableActiveRecord extends MyActiveRecord{
    /**
     * @return array
     */
    public function getOptions() {
//        return CHtml::listData($this->findAll(), 'id', 'name');
        return CMap::mergeArray(array('' => ''), CHtml::listData($this->findAll(), 'id', 'name'));
    }
}
