<?php
/* @var $this CvController */
/* @var $model CvSearchForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Comic Vine index';
$this->breadcrumbs = array(
    'search ComicVine'
);
$this->menu = array(
    array('label' => 'CGridView sample', 'itemOptions' => array('title' => 'sample search for "spiderman"'), 'url' => array('search'), 'authItemName' => 'viewer'),
    array('label' => 'Issues sample', 'itemOptions' => array('title' => 'sample search for volume issues'), 'url' => array('issues', 'volume_id' => '2870'), 'authItemName' => 'viewer'),
);
?>

<h1>search ComicVine</h1>


<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'comicvine-form',
//        'enableClientValidation' => true, // disable to let CDefaultValueValidator work
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'searchString'); ?>
        <?php echo $form->textField($model, 'searchString'); ?>
        <?php echo $form->error($model, 'searchString'); ?>
    </div>
    <!--<div class="row">
        <?php /*echo $form->labelEx($model, 'offset'); */?>
        <?php /*echo $form->listBox($model, 'offset', array(0 => '0', 10 => '10', 20 => '20', 40 => '40')); */?>
        <?php /*echo $form->error($model, 'offset'); */?>
    </div>-->
    <div class="row">
        <?php echo $form->labelEx($model, 'gridview'); ?>
        <?php echo $form->checkBox($model, 'gridview', array('checked' => 'checked')); ?>
        <?php /*echo $form->checkBox($model, 'gridview'); */ ?>
        <?php echo $form->error($model, 'gridview'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Go'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
