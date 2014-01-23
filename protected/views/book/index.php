<?php
/* @var $this BookController */
/* @var $dataProvider CActiveDataProvider */
/* @var $isAdmin boolean*/

$this->breadcrumbs=array(
	'Books',
);

$this->menu=array(
	array('label'=>'Create Book', 'url'=>array('create')),
	array('label'=>'Manage Book', 'url'=>array('admin')),
);
?>

<h1>Books</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'viewData'=>array('isAdmin' => $isAdmin),
	'itemView'=>'_view',
)); ?>
