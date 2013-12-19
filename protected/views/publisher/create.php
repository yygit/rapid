<?php
/* @var $this PublisherController */
/* @var $model Publisher */

$this->breadcrumbs=array(
	'Publishers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Publisher', 'url'=>array('index')),
	array('label'=>'Manage Publisher', 'url'=>array('admin')),
);
?>

<h1>Create Publisher</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>