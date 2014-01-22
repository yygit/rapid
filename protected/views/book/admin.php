<?php
/* @var $this BookController */
/* @var $model Book */

$this->breadcrumbs = array(
    'Books' => array('book/'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Books', 'url' => array('index')),
    array('label' => 'Create Book', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#book-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Books</h1>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
-->
<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'book-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'title',
        'type_id',
        'publication_date',
        'value',
        'price',
        /*
        'notes',
        'signed',
        'grade_id',
        'bagged',
        */
        array(
            'name' => 'lendable',
//            'header' => 'Lendable',
            'value' => '(($data->lendable == 1) ? "yes" : "no")',
        ),
        array(
            'name' => 'borrower_fname',
//            'header' => 'Borrower First Name',
            'value' => '(($data->borrower != null) ? $data->borrower->person->fname . " " : "")',
        ),
        array(
            'name' => 'borrower_lname',
//            'header' => 'Borrower Last Name',
            'value' => '(($data->borrower != null) ? $data->borrower->person->lname . " " : "")',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
