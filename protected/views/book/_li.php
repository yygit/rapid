<?php
echo "<li id=\"author-" . $author->id . "\">" .
    $author->fname . " " . $author->lname .
    " <input class=\"delete\" " . "type=\"button\" url=\"" .
    Yii::app()->controller->createUrl("removeAuthor", array(
        "id" => $model->id,
        "author_id" => $author->id,
        "ajax" => 1
    )) .
    "\" author_id=\"" . $author->id .
    "\" value=\"delete\" />" .
    "</li>";

echo CHtml::ajaxButton('DELETE',
    Yii::app()->createUrl('book/removeAuthor', array(
        "id" => $model->id,
        "author_id" => $author->id,
        "ajax" => 1,
    )),
    array(
        'dataType' => 'html',
        'type' => 'post',
//                'update' => '#ajaxcomments',
        'success' => 'js:function(result) {
//                    $("#ajaxcomments").html(result);
                    alert("ok");
                }',
        'cache' => false,
//        'data' => 'js:jQuery(this).parents("form").serialize()'
    ) // ajax
); // script
