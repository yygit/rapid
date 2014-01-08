<?php
/* @var $this WishController */
/* @var $model Wish */

$this->breadcrumbs=array(
	'Wishes'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Wish', 'url'=>array('index')),
	array('label'=>'Create Wish', 'url'=>array('create')),
	array('label'=>'Update Wish', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Wish', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Wish', 'url'=>array('admin')),
);
?>

<h1>View Wish #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'issue_number',
		'type_id',
		'publication_date',
		'store_link',
		'notes',
		'got_it',
	),
)); ?>
