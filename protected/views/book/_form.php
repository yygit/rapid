<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $form CActiveForm */

/*var_dump(Type::model()->getTypeOptions());
Yii::app()->end();*/
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'book-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableClientValidation' => true,
//        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array( // otherwise, disable ajax globally, see jquery.mobile-config.js
            'data-ajax' => 'false',
        ),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 256)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'issue_number'); ?>
        <?php echo $form->textField($model, 'issue_number', array('size' => 20, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'issue_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type_id'); ?>
        <?php /*echo $form->textField($model,'type_id',array('size'=>10,'maxlength'=>10)); */ ?>
        <?php echo $form->dropDownList($model, 'type_id', Type::model()->getTypeOptions()); ?>
        <?php echo $form->error($model, 'type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'publication_date'); ?>
        <?php /*echo $form->textField($model, 'publication_date'); */ ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'publication_date',
            'attribute' => 'publication_date',
            'model' => $model,
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'altFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
                'appendText' => 'yyyy-mm-dd',
            ),
        ));
        ?>
        <?php echo $form->error($model, 'publication_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'value'); ?>
        <?php echo $form->textField($model, 'value', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'value'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'price'); ?>
        <?php echo $form->textField($model, 'price', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'price'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'notes'); ?>
        <?php echo $form->textArea($model, 'notes', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'notes'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'grade_id'); ?>
        <?php /*echo $form->textField($model, 'grade_id', array('size' => 10, 'maxlength' => 10)); */ ?>
        <?php echo $form->dropDownList($model, 'grade_id', Grade::model()->getTypeOptions()); ?>
        <?php echo $form->error($model, 'grade_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'signed'); ?>
        <?php /*echo $form->textField($model, 'signed'); */ ?>
        <?php echo $form->checkbox($model, 'signed'); ?>
        <?php echo $form->error($model, 'signed'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'bagged'); ?>
        <?php /*echo $form->textField($model, 'bagged'); */ ?>
        <?php echo $form->checkbox($model, 'bagged'); ?>
        <?php echo $form->error($model, 'bagged'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'author'); ?>
        <?php if (Yii::app()->user->hasFlash('authorRemoved')) { ?>
            <div class="flash-success">
                <?php echo Yii::app()->user->getFlash('authorRemoved'); ?>
            </div>
        <?php
        }
        if (Yii::app()->user->hasFlash('authorAdded')) { ?>
            <div class="flash-success">
                <?php echo Yii::app()->user->getFlash('authorAdded'); ?>
            </div>
        <?php
        }
//        else {
            echo $this->renderPartial('/person/_form', array(
                'model' => $author,
                'subform' => 1,
            ));
            if (Yii::app()->controller->action->id != 'create') {
            ?>
                <!--<div class="row buttons">
                    <input class="add" type="button" obj="Person"
                           url="<?php /*echo Yii::app()->controller->createUrl("createAuthor", array("id" => $model->id)); */?>"
                           value="Add"/>
                </div>-->

            <?php
                echo '<div class="row buttons">';
                echo CHtml::ajaxButton('add',
                $this->createUrl('createAuthor', array(
                    "id" => $model->id,
                    "ajax" => 1,
                )),
                array(
                    'dataType' => 'html',
                    'type' => 'get',
                    //  'update' => '#ajaxcomments',
                    'success' => 'js:function(result, textStatus) {
                        // alert("OK: "+textStatus);
                        window.location.reload();
                    }',
                    'error' => 'js:function(jqXHR, textStatus, errorThrown) {
                        alert("ERROR: " + textStatus + " " + errorThrown);
                    }',
                    'beforeSend' => 'js:function() {
                        return confirm("add author to book #'.$model->id.' ?");
                    }',
                    'cache' => false,
                    // 'data' => 'js:jQuery(this).parents("form").serialize()'
                ) // ajax
                ); // script
                echo '</div';
            }
//        } // else
        ?>
        <?php
        if (count($model->authors)) {
            echo "<ul class=\"authors\">";
            foreach ($model->authors as $auth) {
                echo $this->renderPartial('_li', array(
                    'model' => $model,
                    'author' => $auth,
                ));
            }
            echo "</ul>";
        }
        ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
