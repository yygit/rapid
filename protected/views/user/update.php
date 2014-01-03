<?php
/* @var $this UserController */
/* @var $user User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$user->id=>array('view','id'=>$user->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$user->id)),
//	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Update User <?php echo $user->id; ?></h1>

<?php $this->renderPartial('_form', array(
    'user'=>$user,
    'person' => $person,
)); ?>
