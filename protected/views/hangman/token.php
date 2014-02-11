<?php
/* @var $this HangmanController */
/* @var $model HangmanToken */
/* @var $form CActiveForm */
?>

<h1><?php echo $this->route; ?></h1>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hangman-token-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'token'); ?>
        <?php echo $form->textField($model, 'token', array('size' => 40, 'maxlength' => 40)); ?>
        <?php echo $form->error($model, 'token'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
