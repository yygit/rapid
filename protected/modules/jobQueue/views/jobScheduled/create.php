<?php
/* @var $this JobScheduledController */
/* @var $model JobScheduled */

$this->breadcrumbs=array(
	'Job Scheduleds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List JobScheduled', 'url'=>array('index'), 'authItemName' => 'jobQueue@JobScheduledIndex'),
);
?>

<h1>Create JobScheduled</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
