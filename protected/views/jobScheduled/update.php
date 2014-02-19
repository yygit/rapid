<?php
/* @var $this JobScheduledController */
/* @var $model JobScheduled */

$this->breadcrumbs=array(
	'Job Scheduleds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List JobScheduled', 'url'=>array('index')),
	array('label'=>'Create JobScheduled', 'url'=>array('create')),
	array('label'=>'View JobScheduled', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage JobScheduled', 'url'=>array('admin')),
);
?>

<h1>Update JobScheduled <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>