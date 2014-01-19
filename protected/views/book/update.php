<?php
/* @var $this BookController */
/* @var $model Book */

$this->breadcrumbs = array(
    'Books' => array('index'),
    $model->title => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List Books', 'url' => array('index')),
    array('label' => 'Create Book', 'url' => array('create')),
    array('label' => 'View Book', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage Books', 'url' => array('admin')),
);
?>

    <h1>Update Book <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'author'=>$author)); ?>
