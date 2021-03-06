<?php
/* @var $this BookController */
/* @var $model Book */

$this->breadcrumbs = array(
    'Books' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List Book', 'url' => array('index')),
    array('label' => 'Create Book', 'url' => array('create')),
    array('label' => 'Update Book', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Book', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Book', 'url' => array('admin')),
);
?>

<h1>View Book #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'itemCssClass' => array(),
//    'htmlOptions' => array('data-role' => 'table','data-mode' => 'columntoggle', ),
    'attributes' => array(
        'id',
        'title',
        'issue_number',
//		'type_id',
        'type.name',
        'publication_date',
        'value',
        'price',
        'notes',
//        'grade_id',
        'grade.name',
        'signed',
        'bagged',
        array(
            'label' => 'Authors',
            'type' => 'raw',
            'value' => $this->renderPartial('_li2', array('authors' => $model->authors), true),
        ),

    ),
)); ?>
