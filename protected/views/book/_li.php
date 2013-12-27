<?php
/**
 * @var $model Book
 * @var $author Person
 */
/*echo "<li id=\"author-" . $author->id . "\">" .
    $author->fname . " " . $author->lname .
    " <input class=\"delete\" " . "type=\"button\" url=\"" .
    Yii::app()->controller->createUrl("removeAuthor", array(
        "id" => $model->id,
        "author_id" => $author->id,
        "ajax" => 1
    )) .
    "\" author_id=\"" . $author->id .
    "\" value=\"delete\" />" .
    "</li>";*/

echo '<li id="author-' . $author->id . '">' . $author->fname . " " . $author->lname . ' ';
echo CHtml::ajaxButton('delete',
    Yii::app()->createUrl('book/removeAuthor', array(
        "id" => $model->id,
        "author_id" => $author->id,
        "ajax" => 1,
    )),
    array(
        'dataType' => 'html',
        'type' => 'post',
        //  'update' => '#ajaxcomments',
        'success' => 'js:function(result, textStatus) {
            // $("#ajaxcomments").html(result);
            // alert("OK: "+textStatus);
            window.location.reload();
        }',
        'error' => 'js:function(jqXHR, textStatus, errorThrown) {
            alert("ERROR: " + textStatus + " " + errorThrown);
        }',
        'beforeSend' => 'js:function() {
            return confirm("delete author #'.$author->id.' ('.$author->fname.' '.$author->lname.') ?");
        }',
        'cache' => false,
        // 'data' => 'js:jQuery(this).parents("form").serialize()'
    ) // ajax
); // script
echo '</li>';
