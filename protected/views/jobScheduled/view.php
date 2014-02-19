<?php
/* @var $this JobScheduledController */
/* @var $model JobScheduled */

$this->breadcrumbs=array(
	'Job Scheduleds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List JobScheduled', 'url'=>array('index')),
	array('label'=>'Create JobScheduled', 'url'=>array('create')),
	array('label'=>'Update JobScheduled', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete JobScheduled', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage JobScheduled', 'url'=>array('admin')),
);
?>

<h1>View JobScheduled #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'params',
		'output',
		'job_id',
		'scheduled_time',
		'started',
		'completed',
		'active',
	),
)); ?>
