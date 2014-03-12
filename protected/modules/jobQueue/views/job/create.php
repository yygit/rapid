<?php
/* @var $this JobController */
/* @var $model Job */

$this->breadcrumbs=array(
	'Jobs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Jobs', 'url'=>array('job/index')),
    array('label' => 'Job Schedules', 'url' => array('jobScheduled/index')),
);
?>

<h6>Create Job</h6>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
