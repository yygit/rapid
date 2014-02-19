<?php
/* @var $this JobScheduledController */
/* @var $model JobScheduled */

$this->breadcrumbs=array(
	'Job Scheduleds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List JobScheduled', 'url'=>array('index')),
	array('label'=>'Manage JobScheduled', 'url'=>array('admin')),
);
?>

<h1>Create JobScheduled</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>