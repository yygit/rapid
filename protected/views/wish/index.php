<?php
/* @var $this WishController */
/* @var $dataProvider CActiveDataProvider */

/*var_dump(Yii::app()->user->id);
var_dump(Yii::app()->user->name);*/

$this->breadcrumbs=array(
	'Wishes',
);

$this->menu=array(
	array('label'=>'Create Wish', 'url'=>array('create')),
	array('label'=>'Manage Wish', 'url'=>array('admin')),
);
?>

<h1>Wishes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
