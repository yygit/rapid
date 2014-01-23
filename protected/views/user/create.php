<?php
/* @var $this UserController */
/* @var $user User */

Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/user_form_ajax.js');

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List User', 'url' => array('index')),
//	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Create User</h1>

<?php $this->renderPartial('_form', array(
    'user' => $user,
    'person' => $person,
)); ?>
